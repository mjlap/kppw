<?php

namespace App\Console\Commands;

use App\Modules\Finance\Model\FinancialModel;
use App\Modules\Manage\Model\MessageTemplateModel;
use App\Modules\Task\Model\TaskModel;
use App\Modules\Task\Model\TaskTypeModel;
use App\Modules\Task\Model\WorkModel;
use App\Modules\User\Model\CommentModel;
use App\Modules\User\Model\MessageReceiveModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\User\Model\UserModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TaskBidSelectWork extends Command
{
    
    protected $signature = 'taskBidSelectWork';

    
    protected $description = '悬赏模式选稿超出时间';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
        
        $taskTypeId = TaskTypeModel::getTaskTypeIdByAlias('zhaobiao');
        
        $tasks = TaskModel::where('type_id',$taskTypeId)->where('status',4)->get()->toArray();

        
        $expireTasks = self::expireTasks($tasks);

        if(!empty($expireTasks)){
            foreach($expireTasks as $k=>$v)
            {
                $status = DB::transaction(function() use($v)
                {
                    
                    TaskModel::where('id',$v)->update(['status'=>10,'end_at'=>date('Y-m-d H:i:s',time())]);
                    $task = TaskModel::where('id',$v)->first();
                    
                    
                    $task_fail_percentage = $task['task_fail_draw_ratio'];
                    if($task_fail_percentage!=0)
                    {
                        $balance = $task['bounty']*(1-$task_fail_percentage/100);
                    }else{
                        $balance = $task['bounty'];
                    }
                    UserDetailModel::where('uid',$task['uid'])->increment('balance',$balance);
                    
                    $finance_data = [
                        'action'=>7,
                        'pay_type'=>1,
                        'cash'=>$balance,
                        'uid'=>$task['uid'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                        'updated_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    FinancialModel::create($finance_data);

                });
                if(is_null($status))
                {
                    Self::sendMassage($v);
                }
            }
        }




    }

    
    private function expireTasks($data)
    {
        
        $task_select_work = \CommonClass::getConfig('bid_select_work');
        $time = time();
        $expireTasks = [];
        foreach($data as $v)
        {
            if((strtotime($v['delivery_deadline'])+$task_select_work)<=$time)
            {
                $expireTasks[] = $v['id'];
            }
        }

        return $expireTasks;
    }


    
    private function sendMassage ($task_id)
    {
        
        $ids = WorkModel::where('task_id',$task_id)->where('status',0)->lists('uid');
        $ids = array_flatten($ids);
        foreach($ids as $v)
        {
            $task_publish_success = MessageTemplateModel::where('code_name','task_failed')->where('is_open',1)->where('is_on_site',1)->first();
            if($task_publish_success)
            {
                $task = TaskModel::where('id',$task_id)->first();
                $user = UserModel::where('id',$v)->first();
                
                $messageVariableArr = [
                    'task_title'=>$task['title'],
                    'reason'=>'超过选稿限制时间没有选择稿件中标',
                ];
                $message = MessageTemplateModel::sendMessage('task_failed',$messageVariableArr);
                $data = [
                    'message_title'=>$task_publish_success['name'],
                    'code'=>'task_failed',
                    'message_content'=>$message,
                    'js_id'=>$user['id'],
                    'message_type'=>2,
                    'receive_time'=>date('Y-m-d H:i:s',time()),
                    'status'=>0,
                ];
                MessageReceiveModel::create($data);
            }
        }

    }
}
