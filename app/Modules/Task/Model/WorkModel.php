<?php

namespace App\Modules\Task\Model;

use App\Modules\Finance\Model\FinancialModel;
use App\Modules\Manage\Model\MessageTemplateModel;
use App\Modules\User\Model\AttachmentModel;
use App\Modules\User\Model\MessageReceiveModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\User\Model\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;




class WorkModel extends Model
{
    protected $table = 'work';
    public  $timestamps = false;  
    public $fillable = ['desc','task_id','status','uid','bid_at','created_at','price'];

    
    public function childrenAttachment()
    {
        return $this->hasMany('App\Modules\Task\Model\WorkAttachmentModel', 'work_id', 'id');
    }

    
    public function childrenComment()
    {
        return $this->hasMany('App\Modules\Task\Model\WorkCommentModel', 'work_id', 'id');
    }
    
    static function isWorker($uid,$task_id)
    {
        $query = Self::where('uid','=',$uid);
        $query = $query->where(function($query) use($task_id){
            $query->where('task_id',$task_id);
        });
        $result = $query->first();
        if($result) return true;

        return false;
    }

    
    static function isWinBid($task_id,$uid)
    {
        $query = Self::where('task_id',$task_id)->where('status',1)->where('uid',$uid);

        $result = $query->first();

        if($result) return $result['status'];

        return false;
    }

    
    static function findAll($id,$data=array())
    {
        $query = Self::select('work.*','us.name as nickname','a.avatar')
            ->where('work.task_id',$id)->where('work.status','<=',1)->where('forbidden',0);
        
        if(isset($data['work_type'])){
            switch($data['work_type'])
            {
                case 1:
                    $query->where('work.status','=',0);
                    break;
                case 2:
                    $query->where('work.status','=',1);
                    break;
            }
        }
        $data = $query->with('childrenAttachment')
            ->with('childrenComment')
            ->join('user_detail as a','a.uid','=','work.uid')
            ->join('users as us','us.id','=','work.uid')
            ->paginate(5)->setPageName('work_page')->toArray();
        return $data;
    }

    
    static function countWorker($task_id,$status)
    {
        $query = Self::where('status',$status);
        $data = $query->where(function($query) use($task_id){
            $query->where('task_id',$task_id);
        })->count();

        return $data;
    }

    
    public function workCreate($data)
    {
        $status = DB::transaction(function() use($data){
            
            $result = WorkModel::create($data);

            if(isset($data['file_id'])){
                $file_able_ids = AttachmentModel::select('attachment.id','attachment.type')->whereIn('id',$data['file_id'])->get()->toArray();
                
                foreach($file_able_ids as $v){
                    $work_attachment = [
                        'task_id'=>$data['task_id'],
                        'work_id'=>$result['id'],
                        'attachment_id'=>$v['id'],
                        'type'=>$v['type'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    WorkAttachmentModel::create($work_attachment);
                }
            }
            
            UserDetailModel::where('uid',$data['uid'])->increment('receive_task_num',1);
            
            TaskModel::where('id',$data['task_id'])->increment('delivery_count',1);
            
            $work = WorkModel::where('task_id',$data['task_id'])->count();
            if($work==1)
            {
                TaskModel::where('id',$data['task_id'])->update(['status'=>4]);
            }
        });

        return is_null($status)?true:false;
    }

    
    public function winBid($data)
    {
        $status = DB::transaction(function() use($data){
            
            Self::where('id',$data['work_id'])->update(['status'=>1,'bid_at'=>date('Y-m-d H:s:i',time())]);
            
            $win_bid_num = self::where('task_id',$data['task_id'])->where('status',1)->count();
            if($win_bid_num==1)
            {
                TaskModel::where('id',$data['task_id'])->update(['status'=>5,'selected_work_at'=>date('Y-m-d H:i:s',time())]);
            }
            
            if(($data['win_bid_num']+1)== $data['worker_num'])
            {
                
                
                
                $task_publicity_day = \CommonClass::getConfig('task_publicity_day');
                if($task_publicity_day==0)
                {
                    TaskModel::where('id',$data['task_id'])->update(['status'=>7,'publicity_at'=>date('Y-m-d H:i:s',time()),'checked_at'=>date('Y-m-d H:i:s',time())]);
                }else{
                    TaskModel::where('id',$data['task_id'])->update(['status'=>6,'publicity_at'=>date('Y-m-d H:i:s',time())]);
                }

            }
        });
        
        if(is_null($status)){
            
            self::sendTaskWidMessage($data);
        }
        return is_null($status)?true:false;
    }

    
    static public function findDelivery($id,$data)
    {
        $query = Self::select('work.*','us.name as nickname','a.avatar')
            ->where('work.task_id',$id)->where('work.status','>=',2);
        
        if(isset($data['evaluate'])){
            switch($data['evaluate'])
            {
                case 1:
                    $query->where('status','>=',0);
                    break;
                case 2:
                    $query->where('status','>=',1);
                    break;
                case 3:
                    $query->where('status','>=',2);
            }
        }
        $data = $query->with('childrenAttachment')
            ->join('user_detail as a','a.uid','=','work.uid')
            ->leftjoin('users as us','us.id','=','work.uid')
            ->paginate(5)->setPageName('delivery_page')->toArray();
        return $data;
    }

    
    static public function findRights($id)
    {
        $data = Self::select('work.*','us.name as nickname','ud.avatar')
            ->where('task_id',$id)->where('work.status',4)
            ->with('childrenAttachment')
            ->join('user_detail as ud','ud.uid','=','work.uid')
            ->leftjoin('users as us','us.id','=','work.uid')
            ->paginate(5)->setPageName('delivery_page')->toArray();
        return $data;
    }
    
    static public function delivery($data)
    {
        $status = DB::transaction(function() use($data){
            
            $result = WorkModel::create($data);

            if(isset($data['file_id'])){
                $file_able_ids = AttachmentModel::select('attachment.id','attachment.type')->whereIn('id',$data['file_id'])->get()->toArray();
                
                foreach($file_able_ids as $v){
                    $work_attachment = [
                        'task_id'=>$data['task_id'],
                        'work_id'=>$result['id'],
                        'attachment_id'=>$v['id'],
                        'type'=>$v['type'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    WorkAttachmentModel::create($work_attachment);
                }
            }

        });

        return is_null($status)?true:false;
    }

    
    static public function workCheck($data)
    {
        $status = DB::transaction(function() use($data) {
            
            self::where('id', $data['work_id'])->update(['status' => 3, 'bid_at' => date('Y-m-d H:i:s', time())]);
            
            TaskModel::distributeBounty($data['task_id'],$data['uid']);

            
            if(($data['win_check']+1)==$data['worker_num'])
            {
                TaskModel::where('id',$data['task_id'])->update(['status'=>8,'comment_at'=>date('Y-m-d H:i:s',time())]);
            }
        });
        
        if(is_null($status))
        {
            
            $manuscript_settlement = MessageTemplateModel::where('code_name','manuscript_settlement')->where('is_open',1)->where('is_on_site',1)->first();
            if($manuscript_settlement)
            {
                $task = TaskModel::where('id',$data['task_id'])->first();
                $work = WorkModel::where('id',$data['work_id'])->first();
                $user = UserModel::where('id',$work['uid'])->first();
                $site_name = \CommonClass::getConfig('site_name');
                $domain = \CommonClass::getDomain();
                
                
                $messageVariableArr = [
                    'username'=>$user['name'],
                    'task_number'=>$task['id'],
                    'task_link'=>$domain.'/task/'.$task['id'],
                    'website'=>$site_name,
                ];
                $message = MessageTemplateModel::sendMessage('manuscript_settlement',$messageVariableArr);
                $data = [
                    'message_title'=>'任务验收通知',
                    'message_content'=>$message,
                    'js_id'=>$user['id'],
                    'message_type'=>2,
                    'receive_time'=>date('Y-m-d H:i:s',time()),
                    'status'=>0,
                ];
                MessageReceiveModel::create($data);
            }
        }
        return is_null($status)?true:false;
    }


    
    static public function bidWinBid($data)
    {
        $status = DB::transaction(function() use($data){
            
            self::where('id',$data['work_id'])->update(['status'=>1,'bid_at'=>date('Y-m-d H:s:i',time())]);
            $bounty = self::find($data['work_id'])->price;
            
            TaskModel::where('id',$data['task_id'])->update(['bounty' => $bounty,'status'=>5,'selected_work_at'=>date('Y-m-d H:i:s',time())]);

        });
        return is_null($status)?true:false;
    }

    
    static public function sendTaskWidMessage($arr)
    {
        $res = true;
        
        $task_win = MessageTemplateModel::where('code_name','task_win')->where('is_open',1)->where('is_on_site',1)->first();
        if($task_win)
        {
            $task = TaskModel::where('id',$arr['task_id'])->first();
            $work = WorkModel::where('id',$arr['work_id'])->first();
            $user = UserModel::where('id',$work['uid'])->first();
            $site_name = \CommonClass::getConfig('site_name');
            $domain = \CommonClass::domain();
            
            $messageVariableArr = [
                'username'=>$user['name'],
                'website'=>$site_name,
                'task_number'=>$task['id'],
                'href' => $domain.'/task/'.$task['id'],
                'task_title'=>$task['title'],
                'win_price'=>$task['bounty']/$task['worker_num'],
            ];
            $message = MessageTemplateModel::sendMessage('task_win',$messageVariableArr);
            $data = [
                'message_title'=>'任务中标通知',
                'message_content'=>$message,
                'js_id'=>$user['id'],
                'message_type'=>2,
                'receive_time'=>date('Y-m-d H:i:s',time()),
                'status'=>0,
            ];
            $res = MessageReceiveModel::create($data);
        }
        return $res;
    }

    
    static public function bidDelivery($data)
    {
        $status = DB::transaction(function() use($data){
            
            $paySection = TaskPaySectionModel::where('task_id',$data['task_id'])->where('case_status',1)->where('sort',$data['sort'])->first();
            if(!empty($paySection['work_id']) && $paySection['verify_status'] == 2){
                
                WorkModel::where('id',$paySection['work_id'])->delete();
                WorkAttachmentModel::where('work_id',$paySection['work_id'])->delete();
            }
            
            $workInfo = [
                'desc' => $data['desc'],
                'task_id' => $data['task_id'],
                'status' => 2,
                'forbidden' => 0,
                'uid' => $data['uid'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            $result = WorkModel::create($workInfo);

            if(isset($data['file_id'])){
                $file_able_ids = AttachmentModel::select('attachment.id','attachment.type')->whereIn('id',$data['file_id'])->get()->toArray();
                
                foreach($file_able_ids as $v){
                    $work_attachment = [
                        'task_id' => $data['task_id'],
                        'work_id' => $result['id'],
                        'attachment_id' => $v['id'],
                        'type' => $v['type'],
                        'created_at' => date('Y-m-d H:i:s',time()),
                    ];
                    WorkAttachmentModel::create($work_attachment);
                }
            }

            
            $paySectionInfo = [
                'work_id' => $result['id'],
                'verify_status' => 0,
                'section_status' => 1, 
                'updated_at' => date('Y-m-d H:i:s')
            ];
            TaskPaySectionModel::where('task_id',$data['task_id'])->where('case_status',1)->where('sort',$data['sort'])->update($paySectionInfo);

        });

        return is_null($status)?true:false;
    }

    
    static public function bidWorkCheck($data)
    {
        if($data['status'] == 1){
            $status = DB::transaction(function() use($data) {

                
                self::where('id', $data['work_id'])->update(['status' => 3, 'bid_at' => date('Y-m-d H:i:s', time())]);
                
                $task = TaskModel::find($data['task_id']);
                $percent = $task->task_success_draw_ratio;
                $paySection = TaskPaySectionModel::where('task_id',$data['task_id'])
                    ->where('work_id',$data['work_id'])->first();
                
                $paySectionInfo = [
                    'status' => 1,
                    'verify_status' => 1,
                    'section_status' => 3,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'pay_at' => date('Y-m-d H:i:s'),
                ];

                TaskPaySectionModel::where('task_id',$data['task_id'])
                    ->where('work_id',$data['work_id'])
                    ->update($paySectionInfo);
                if($percent){
                    $price = $paySection['price'] -intval($paySection['price']*$percent/100);
                }else{
                    $price =  $paySection['price'];
                }
                
                UserDetailModel::where('uid', $data['uid'])->increment('balance', $price);
                
                $finance_data = [
                    'action' => 2,
                    'pay_type' => 1,
                    'cash' => $price,
                    'uid' => $data['uid'],
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time())
                ];
                FinancialModel::create($finance_data);

                
                $isFinish = TaskPaySectionModel::where('task_id',$data['task_id'])
                    ->where('section_status','<',3)->first();
                if(empty($isFinish)){
                    TaskModel::where('id',$data['task_id'])->update(['status'=>8,'comment_at'=>date('Y-m-d H:i:s',time())]);
                }

            });
            
            if(is_null($status))
            {
                
                $manuscript_settlement = MessageTemplateModel::where('code_name','bid_work_check_success')->where('is_open',1)->where('is_on_site',1)->first();
                if($manuscript_settlement)
                {
                    $task = TaskModel::where('id',$data['task_id'])->first();
                    $work = WorkModel::where('id',$data['work_id'])->first();
                    $user = UserModel::where('id',$work['uid'])->first();
                    $site_name = \CommonClass::getConfig('site_name');
                    $domain = \CommonClass::getDomain();
                    
                    
                    $messageVariableArr = [
                        'username'=>$user['name'],
                        'task_name'=>$task['title'],
                        'task_link'=>$domain.'/task/'.$task['id'],
                        'website'=>$site_name,
                    ];
                    $message = MessageTemplateModel::sendMessage('bid_work_check_success',$messageVariableArr);
                    $data = [
                        'message_title'=>'任务验收通知',
                        'message_content'=>$message,
                        'js_id'=>$user['id'],
                        'message_type'=>2,
                        'receive_time'=>date('Y-m-d H:i:s',time()),
                        'status'=>0,
                    ];
                    MessageReceiveModel::create($data);
                }
            }
        }else{
            $status = DB::transaction(function() use($data) {

                
                self::where('id', $data['work_id'])->update(['status' => 5]);
                
                $paySectionInfo = [
                    'verify_status' => 2,
                    'section_status' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                TaskPaySectionModel::where('task_id',$data['task_id'])
                    ->where('work_id',$data['work_id'])->update($paySectionInfo);

            });
            
            if(is_null($status))
            {
                
                $manuscript_settlement = MessageTemplateModel::where('code_name','bid_work_check_failure')->where('is_open',1)->where('is_on_site',1)->first();
                if($manuscript_settlement)
                {
                    $task = TaskModel::where('id',$data['task_id'])->first();
                    $work = WorkModel::where('id',$data['work_id'])->first();
                    $user = UserModel::where('id',$work['uid'])->first();
                    $site_name = \CommonClass::getConfig('site_name');
                    $domain = \CommonClass::getDomain();
                    
                    
                    $messageVariableArr = [
                        'username'=>$user['name'],
                        'task_name'=>$task['title'],
                        'task_link'=>$domain.'/task/'.$task['id'],
                        'website'=>$site_name,
                    ];
                    $message = MessageTemplateModel::sendMessage('bid_work_check_failure',$messageVariableArr);
                    $data = [
                        'message_title'=>'任务验收通知',
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

        return is_null($status)?true:false;
    }

}
