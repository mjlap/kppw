<?php

namespace App\Modules\Task\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TaskRightsModel extends Model
{
    protected $table = 'task_rights';
    public $timestamps = false;
    protected $fillable = [
        'role','type','task_id','work_id','desc','status','from_uid','to_uid','created_at','handled_at'
    ];

    
    public static function rightCreate($data)
    {
        $status = DB::transaction(function() use($data){
            Self::create($data);
            
            WorkModel::where(['task_id' => $data['task_id'],'status' => 2])->whereIn('uid',[$data['from_uid'],$data['to_uid']])->update(['status'=>4]);
            
            $task_data = TaskModel::where('id',$data['task_id'])->first();

            if($task_data['worker_num']==1)
            {
                TaskModel::where('id',$data['task_id'])->update(['status'=>11,'end_at'=>date('Y-m-d H:i:s',time())]);
            }
            
            if($task_data['worker_num']!=1)
            {
                
                $work_checked = WorkModel::where('status',2)->count();
                $work_checked_works = WorkModel::where('status',3)->count();
                
                if($work_checked_works==0 && $work_checked==0)
                {
                    TaskModel::where('id',$data['task_id'])->update(['status'=>11]);
                }elseif($work_checked==0){
                    TaskModel::where('id',$data['task_id'])->update(['status'=>8,'comment_at'=>date('Y-m-d H:i:s',time())]);
                }
            }
        });
        return is_null($status)?true:false;
    }

    
    public static function bidRightCreate($data)
    {
        $status = DB::transaction(function() use($data){
            self::create($data);
            
            WorkModel::where(['task_id' => $data['task_id'],'status' => 2])->whereIn('uid',[$data['from_uid'],$data['to_uid']])->update(['status'=>4]);
            
            $paySectionInfo = [
                'section_status' => 2,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            TaskPaySectionModel::where('task_id',$data['task_id'])
                ->where('work_id',$data['work_id'])->update($paySectionInfo);

            
            TaskModel::where('id',$data['task_id'])->update(['status'=>11,'updated_at' => date('Y-m-d H:i:s')]);
        });
        return is_null($status)?true:false;
    }
}
