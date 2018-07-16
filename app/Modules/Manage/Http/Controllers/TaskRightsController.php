<?php
namespace App\Modules\Manage\Http\Controllers;

use App\Http\Controllers\ManageController;
use App\Http\Requests;
use App\Http\Controllers\BasicController;
use App\Modules\Finance\Model\FinancialModel;
use App\Modules\Manage\Model\MessageTemplateModel;
use App\Modules\Task\Model\TaskModel;
use App\Modules\Task\Model\TaskTypeModel;
use App\Modules\Task\Model\TaskReportModel;
use App\Modules\Task\Model\TaskRightsModel;
use App\Modules\Task\Model\TaskPaySectionModel;
use App\Modules\Task\Model\WorkModel;
use App\Modules\User\Model\AttachmentModel;
use App\Modules\User\Model\MessageReceiveModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\User\Model\UserModel;
use App\Modules\Manage\Model\ConfigModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskRightsController extends ManageController
{
    public $user;
    public function __construct()
    {
        parent::__construct();
        $this->user = $this->manager;
        $this->initTheme('manage');
        $this->theme->setTitle('交易维权');
        $this->theme->set('manageType', 'TaskRights');
    }

    
    public function rightsList(Request $request)
    {
        $data = $request->all();
        $query = TaskRightsModel::select('task_rights.*', 'ud.name as from_nickname', 'userd.name as to_nickname', 'mg.username as handle_nickname');
        
        if ($request->get('username')) {
            $query = $query->where('ud.name','like','%'.$request->get('username').'%');
        }
        
        if ($request->get('reportType') && $request->get('reportType') != 0) {
            $query = $query->where('task_rights.type', $request->get('reportType'));
        }
        
        if ($request->get('reportStatus') && $request->get('reportStatus') != 0) {

            $query = $query->where('task_rights.status', $request->get('reportStatus') - 1);
        }
        
        $timeType = 'task_rights.created_at';
        if($request->get('start')){
            $start = date('Y-m-d H:i:s',strtotime($request->get('start')));
            $query = $query->where($timeType,'>',$start);

        }
        if($request->get('end')){
            $end = date('Y-m-d H:i:s',strtotime($request->get('end')));
            $query = $query->where($timeType,'<',$end);
        }
        
        $page_size = 10;
        $reports_page = $query->join('users as ud', 'ud.id', '=', 'task_rights.from_uid')
            ->leftjoin('users as userd', 'userd.id', '=', 'task_rights.to_uid')
            ->leftjoin('manager as mg', 'mg.id', '=', 'task_rights.handle_uid')
            ->orderBy('task_rights.id','DESC')
            ->paginate($page_size);
        $reports = $reports_page->toArray();
        
        $rights_type = [
            'type'=>[
                1=>'违规信息',
                2=>'虚假交换',
                3=>'涉嫌抄袭',
                4=>'其他',
            ],
        ];
        $reports['data'] = \CommonClass::intToString($reports['data'],$rights_type);

        $view = [
            'rights' => $reports,
            'merge' => $data,
            'reports_page'=>$reports_page
        ];

        return $this->theme->scope('manage.taskrights', $view)->render();
    }

    
    public function rightsDetail($id)
    {
        
        $preId = TaskRightsModel::where('id', '>', $id)->min('id');
        
        $nextId = TaskRightsModel::where('id', '<', $id)->max('id');
        $rights = TaskRightsModel::where('id',$id)->first();
        $work = WorkModel::where('id',$rights['work_id'])->first();
		$taskPaySection=TaskPaySectionModel::select('price')->where('task_id',$rights['task_id'])->where('status',0)->where('section_status',2)->first();
        $task = TaskModel::where('id',$rights['task_id'])->first();
		$task['bounty']=$taskPaySection?$taskPaySection['price']:$task['bounty'];
        $from_user = UserModel::select('users.*','users.name as nickname','ud.mobile','ud.qq')
            ->where('users.id',$rights['from_uid'])
            ->leftjoin('user_detail as ud','ud.uid','=','users.id')
            ->first();

        $to_user = UserModel::select('users.*','users.name as nickname','ud.mobile','ud.qq')
            ->where('users.id',$rights['to_uid'])
            ->leftjoin('user_detail as ud','ud.id','=','users.id')
            ->first();
        
        $attachment = [];
        if(!empty(json_decode($rights['attachment_ids'])))
        {
            $attachment = AttachmentModel::whereIn('id',json_decode($rights['attachment_ids']))->get();
        }

        $view = [
            'report'=>$rights,
            'from_user'=>$from_user,
            'to_user'=>$to_user,
            'task'=>$task,
            'work'=>$work,
            'preId'=>$preId,
            'nextId'=>$nextId,
            'attachment'=>$attachment
        ];

        return $this->theme->scope('manage.rightsdetail', $view)->render();
    }

    
    public function rightsDelet($id)
    {
        
        $result = TaskRightsModel::destroy($id);
        if(!$result)
            return redirect()->to('/manage/rightsList')->with(['error'=>'删除失败！']);

        return redirect()->to('/manage/rightsList')->with(['massage'=>'删除成功！']);
    }

    
    public function rightsDeletGroup(Request $request)
    {
        $data = $request->except('_token');

        $result = TaskRightsModel::whereIn($data['id'])->delete();

        if(!$result)
            return redirect()->to('/manage/rightsList')->with(['error'=>'删除失败!']);

        return redirect()->to('/manage/rightsList')->with(['massage'=>'删除成功！']);
    }

    
    public function handleRights(Request $request)
    {
        $data = $request->except('_token');
		if($data['worker_bounty']=='' || $data['owner_bounty']==''){
			return redirect()->back()->with(['error'=>'雇主或威客分配金额不能为空']);
		}
        $rights = TaskRightsModel::where('id',$data['id'])->first();
        
		$taskPaySection=TaskPaySectionModel::select('price')->where('task_id',$rights['task_id'])->where('status',0)->where('section_status',2)->first();        
		
        $task = TaskModel::where('id',$rights['task_id'])->first();
		if($task['status'] == 10){
			return redirect()->back()->with(['error'=>'该任务已处于失败中，金额已处理完']);
		}
        $bounty =$taskPaySection?floor($taskPaySection['price']/$task['worker_num']):floor($task['bounty']/$task['worker_num']);
		
        if(($data['worker_bounty']+$data['owner_bounty'])>$bounty)
        {
            return redirect()->back()->with(['error'=>'赏金分配超额']);
        }
        if($rights['role']==0)
        {
            $worker_id = $rights['from_uid'];
            $owner_id = $rights['to_uid'];
        }else{
            $worker_id = $rights['to_uid'];
            $owner_id = $rights['from_uid'];
        }
        
        $status = DB::transaction(function() use($data,$rights,$bounty,$worker_id,$owner_id,$task)
        {
            
            if($task['status']==11)
            {
                TaskModel::where('id',$task['id'])->update(['status'=>10,'end_at'=>date('Y-m-d',time())]);
            }
            
            $handle = [
                'status'=>1,
                'handle_uid'=>$this->user['id'],
                'handled_at'=>date('Y-m-d H:i:s',time())
            ];
            TaskRightsModel::where('id',$data['id'])->update($handle);
            
			$taskPaySectionAll=TaskPaySectionModel::select('price')->where('task_id',$rights['task_id'])->where('status',0)->where('section_status',0)->get();
			
			$taskType=TaskTypeModel::select('alias')->where('id',$task['type_id'])->first();
			switch($taskType['alias']){
				case 'xuanshang':
				$configType="task";
				
				$configEro="task_fail_percentage";
				break;
				case 'guyong':
				break;
				case 'zhaobiao':
				$configType="bid";
				
				$configEro="bid_fail_percentage";
				break;	
			}				
			if(sizeof($taskPaySectionAll)){
				
				$config=ConfigModel::select("rule")->where('type',$configType)->where('alias',$configEro)->first();
				
				foreach($taskPaySectionAll as $Vtpsa){
				  $data['owner_bounty']+=floor($Vtpsa['price']*(100-$config['rule'])*0.01);
				}
			}
            
            if($data['worker_bounty']!=0)
            {
                UserDetailModel::where('uid',$worker_id)->increment('balance',$data['worker_bounty']);
                
                $finance_data = [
                    'action'=>2,
                    'pay_type'=>1,
                    'cash'=>$data['worker_bounty'],
                    'uid'=>$worker_id,
                    'created_at'=>date('Y-m-d H:i:s',time()),
                ];
                FinancialModel::create($finance_data);
            }
            
            if($data['owner_bounty']!=0)
            {
                UserDetailModel::where('uid',$owner_id)->increment('balance',$data['owner_bounty']);
                
                $finance_data = [
                    'action'=>7,
                    'pay_type'=>1,
                    'cash'=>$data['owner_bounty'],
                    'uid'=>$owner_id,
                    'created_at'=>date('Y-m-d H:i:s',time()),
                ];
                FinancialModel::create($finance_data);
            }
        });

        
        if(!is_null($status))
        {
            return redirect()->back()->with(['error'=>'维权处理失败！']);
        }
        $trading_rights_result  = MessageTemplateModel::where('code_name','trading_rights_result')->where('is_open',1)->where('is_on_site',1)->first();
        if($trading_rights_result)
        {
            $task = TaskModel::where('id',$rights['task_id'])->first();
            $worker_user = UserModel::where('id',$worker_id)->first();
            $owner_user = UserModel::where('id',$owner_id)->first();
            $site_name = \CommonClass::getConfig('site_name');
            
            
            $ownerMessageVariableArr = [
                'username'=>$owner_user['name'],
                'tasktitle'=>$task['title'],
                'ownername'=>$owner_user['name'],
                'ownermoney'=>$data['owner_bounty'],
                'workername'=>$worker_user['name'],
                'wokermoney'=>$data['worker_bounty'],
                'website'=>$site_name,
            ];
            $ownerMessage = MessageTemplateModel::sendMessage('trading_rights_result',$ownerMessageVariableArr);
            $message1 = [
                'message_title'=>$trading_rights_result['name'],
                'code'=>'trading_rights_result',
                'message_content'=>$ownerMessage,
                'js_id'=>$owner_user['id'],
                'message_type'=>2,
                'receive_time'=>date('Y-m-d H:i:s',time()),
                'status'=>0,
            ];
            MessageReceiveModel::create($message1);
            
            $workerMessageVariableArr = [
                'username'=>$worker_user['name'],
                'tasktitle'=>$task['title'],
                'ownername'=>$owner_user['name'],
                'ownermoney'=>$data['owner_bounty'],
                'workername'=>$worker_user['name'],
                'wokermoney'=>$data['worker_bounty'],
                'website'=>$site_name,
            ];
            $workerMessage = MessageTemplateModel::sendMessage('trading_rights_result',$workerMessageVariableArr);
            $message2 = [
                'message_title'=>$trading_rights_result['name'],
                'code'=>'trading_rights_result',
                'message_content'=>$workerMessage,
                'js_id'=>$worker_user['id'],
                'message_type'=>2,
                'receive_time'=>date('Y-m-d H:i:s',time()),
                'status'=>0,
            ];
            MessageReceiveModel::create($message2);
        }
        return redirect()->back()->with(['massage'=>'维权处理成功！']);

    }
	
	


}
