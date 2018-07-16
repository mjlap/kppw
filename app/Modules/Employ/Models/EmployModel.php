<?php

namespace App\Modules\Employ\Models;

use App\Modules\Finance\Model\FinancialModel;
use App\Modules\Manage\Model\ConfigModel;
use App\Modules\Order\Model\ShopOrderModel;
use App\Modules\Shop\Models\GoodsModel;
use App\Modules\User\Model\AttachmentModel;
use App\Modules\User\Model\UserDetailModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployModel extends Model
{
    protected $table = 'employ';
    public $timestamps = false;
    protected $fillable = [
        'title', 'desc', 'phone', 'bounty', 'delivery_deadline', 'status', 'employee_uid', 'employer_uid', 'employ_percentage', 'cancel_at', 'except_max_at', 'accept_deadline', 'created_at', 'updated_at',
        'seo_keywords', 'seo_title', 'seo_content', 'accept_at', 'right_allow_at', 'employ_type'
    ];

    
    static public function employCreate($data)
    {
        $status = DB::transaction(function () use ($data) {
            
            $result = self::create($data);
            
            if ($data['service_id'] != 0) {
                
                GoodsModel::where('id', $data['service_id'])->increment('sales_num', 1);
                EmployGoodsModel::create(['employ_id' => $result['id'], 'service_id' => $data['service_id'], 'created_at' => date('Y-m-d H:i:s', time())]);
            }
            
            if (!empty($data['file_id'])) {
                
                $file_able_ids = AttachmentModel::fileAble($data['file_id']);
                $file_able_ids = array_flatten($file_able_ids);
                foreach ($file_able_ids as $v) {
                    $attachment_data[] = [
                        'object_id' => $result['id'],
                        'object_type' => 2,
                        'attachment_id' => $v,
                        'created_at' => date('Y-m-d H:i:s', time()),
                    ];
                }
                UnionAttachmentModel::insert($attachment_data);
                
                $attachmentModel = new AttachmentModel();
                $attachmentModel->statusChange($file_able_ids);
            }

            
            UserDetailModel::where('id', intval($data['employee_uid']))->increment('employee_num', 1);

            return $result;
        });

        return $status;
    }

    
    static public function employBounty($money, $employ_id, $uid, $code, $type = 1)
    {
        $status = DB::transaction(function () use ($money, $employ_id, $uid, $code, $type) {
            
            DB::table('user_detail')->where('uid', '=', $uid)->where('balance_status', '!=', 1)->decrement('balance', $money);
            
            
            $employ_configs = ConfigModel::where('type', 'employ')->get()->toArray();
            $employ_configs = \CommonClass::keyBy($employ_configs, 'alias');
            
            $data['employ_percentage'] = $employ_configs['employ_percentage']['rule'];
            $data['cancel_at'] = date('Y-m-d H:i:s', time() + $employ_configs['employer_cancel_time']['rule'] * 3600);
            $data['except_max_at'] = date('Y-m-d H:i:s', time() + $employ_configs['employ_except_time']['rule'] * 3600);
            $data['bounty_status'] = 1;
            self::where('id', $employ_id)->update($data);

            
            $financial = [
                'action' => 1,
                'pay_type' => $type,
                'cash' => $money,
                'uid' => $uid,
                'created_at' => date('Y-m-d H:i:s', time())
            ];
            FinancialModel::create($financial);
            
            ShopOrderModel::where('code', $code)->update(['status' => 1]);

            
            UserDetailModel::where('uid', $uid)->increment('publish_task_num', 1);
        });

        return is_null($status) ? true : false;
    }

    
    static function employResult()
    {

    }

    
    static public function employDetail($id)
    {
        $query = self::select('employ.*', 'a.name as user_name')
            ->where('employ.id', '=', $id);
        



        $data = $query->leftjoin('users as a', 'a.id', '=', 'employ.employer_uid')->first();
        return $data;
    }

    
    static public function employHandle($type, $task_id, $user_id)
    {
        $result = false;
        
        $task = self::where('id', $task_id)->where('status', 0)->first();
        if (!$task || $task['status'] != 0) {
            return $result;
        }

        if ($type == 1) {
            
            if ($task['employer_uid'] != $user_id || date('Y-m-d H:i:s', time()) < $task['cancel_at'])
                return $result;
            
           $result = DB::transaction(function() use($task_id,$task){
                
                $result = self::where('id', $task_id)->update(['status' => 6, 'end_at' => date('Y-m-d H:i:s', time())]);
                
                UserDetailModel::where('uid',$task['employer_uid'])->increment(['balance'=>$task['bounty']]);
                
                $financial = [
                    'action' => 7,
                    'pay_type' => 1,
                    'cash' => $task['bounty'],
                    'uid' => $task['employer_uid'],
                    'created_at' => date('Y-m-d H:i:s', time()),
                ];
                FinancialModel::create($financial);

            });
            return is_null($result)?true:false;

        } else if ($type == 2) {
            $result = self::where('id', $task_id)->where('employee_uid', $user_id)
                ->update(['status' => 1, 'begin_at' => date('Y-m-d H:i:s', time())]);
        } else if ($type == 3) {
            $result = DB::transaction(function() use($task_id,$task,$user_id){
                
                $result = self::where('id', $task_id)->where('employee_uid', $user_id)
                    ->update(['status' => 5, 'end_at' => date('Y-m-d H:i:s', time())]);

                
                UserDetailModel::where('uid',$task['employer_uid'])->increment('balance',$task['bounty']);

                
                $financial = [
                    'action' => 7,
                    'pay_type' => 1,
                    'cash' => $task['bounty'],
                    'uid' => $task['employer_uid'],
                    'created_at' => date('Y-m-d H:i:s', time()),
                ];
                FinancialModel::create($financial);

            });

            return is_null($result)?true:false;
        }
        return $result;
    }

    
    static public function acceptWork($id, $uid)
    {
        $status = DB::transaction(function () use ($id, $uid) {
            
            $comment_deadline = \CommonClass::getConfig('employ_comment_time');
            if ($comment_deadline != 0) {
                $comment_deadline = time() + $comment_deadline * 24 * 3600;
            } else {
                $comment_deadline = time() + 7 * 24 * 3600;
            }

            self::where('id', $id)->update(['status' => 3, 'accept_at' => date('Y-m=d H:i:s', time()), 'comment_deadline' => date('Y-m-d H:i:s', $comment_deadline)]);
            $employ = self::where('id', $id)->first()->toArray();
            
            
            $bounty = $employ['bounty'] * (1 - $employ['employ_percentage'] / 100);

            UserDetailModel::where('uid', $employ['employee_uid'])->increment('balance', $bounty);
            
            $finance_data = [
                'action' => 2,
                'pay_type' => 1,
                'cash' => $bounty,
                'uid' => $employ['employee_uid'],
                'created_at' => date('Y-m-d H:i:s', time())
            ];
            FinancialModel::create($finance_data);
        });
        return is_null($status) ? true : false;
    }

    
    static public function employAccept($employ)
    {
        $status = DB::transaction(function () use ($employ) {
            $time = date('Y-m-d H:i:s', time());
            
            self::where('id', $employ['id'])->update(['status' => 9, 'end_at' => $time]);
            
            UserDetailModel::where('uid', $employ['employer_uid'])->increment('balance', $employ['bounty']);
            
            
            $finance_data = [
                'action' => 7,
                'pay_type' => 1,
                'cash' => $employ['bounty'],
                'uid' => $employ['employer_uid'],
                'created_at' => $time
            ];
            FinancialModel::create($finance_data);
        });
        return is_null($status) ? true : false;
    }

    
    static public function employDelivery($employ)
    {
        $status = DB::transaction(function () use ($employ) {
            $time = date('Y-m-d H:i:s', time());
            
            self::where('id', $employ['id'])->update(['status' => 4, 'end_at' => $time]);
            
            EmployWorkModel::where('employ_id', $employ['id'])->update(['status' => 1]);
            
            UserDetailModel::where('uid', $employ['employee_uid'])->increment('balance', $employ['bounty']);
            
            $finance_data = [
                'action' => 2,
                'pay_type' => 1,
                'cash' => $employ['bounty'],
                'uid' => $employ['employee_uid'],
                'created_at' => $time
            ];
            FinancialModel::create($finance_data);
        });
        return is_null($status) ? true : false;
    }

    
    static public function employDeadline($employ)
    {
        $status = DB::transaction(function () use ($employ) {
            $time = date('Y-m-d H:i:s', time());
            self::where('id', $employ['id'])->update(['status' => 9, 'end_at' => $time]);

            
            UserDetailModel::where('uid', $employ['employer_uid'])->increment('balance', $employ['bounty']);
            
            $finance_data = [
                'action' => 7,
                'pay_type' => 1,
                'cash' => $employ['bounty'],
                'uid' => $employ['employer_uid'],
                'created_at' => $time
            ];
            FinancialModel::create($finance_data);
        });

        return is_null($status) ? true : false;
    }

    
    static public function employComment($employ)
    {
        $status = DB::transaction(function () use ($employ) {
            
            self::where('id', $employ['id'])->where('status', 3)->update(['status' => 4, 'end_at' => date('Y-m-d H:i:s', time())]);

            
            $result = EmployCommentsModel::where('employ_id', $employ['id'])->where('comment_by', 1)->first();
            if (!$result) {
                $employ_comment = [
                    'employ_id' => $employ['id'],
                    'from_uid' => $employ['employer_uid'],
                    'to_uid' => $employ['employee_uid'],
                    'comment_by' => 3,
                    'speed_score' => 5,
                    'quality_score' => 5,
                    'attitude_score' => 5,
                    'type' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                ];
                EmployCommentsModel::create($employ_comment);
            }
            
            $result2 = EmployCommentsModel::where('employ_id', $employ['id'])->where('comment_by', 0)->first();
            if (!$result2) {
                $employ_comment = [
                    'employ_id' => $employ['id'],
                    'from_uid' => $employ['employee_uid'],
                    'to_uid' => $employ['employer_uid'],
                    'comment_by' => 3,
                    'speed_score' => 5,
                    'quality_score' => 5,
                    'attitude_score' => 0,
                    'type' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                ];
                EmployCommentsModel::create($employ_comment);
            }
        });
    }

    
    static public function employMine($uid, $data,$paginate=5)
    {
        $employ = self::select('employ.*', 'us.name as user_name', 'ud.avatar')->where('employer_uid', $uid)->where('bounty_status', 1);

        if (isset($data['employ_type']) && $data['employ_type'] != 'all') {
            $employ = $employ->where('employ.employ_type', $data['employ_type']);
        }
        if (isset($data['time']) && $data['time'] != 'all') {
            $time = date('Y-m-d H:i:s', strtotime("-" . intval($data['time']) . " month"));
            $employ = $employ->where('employ.created_at', '>', $time);
        }
        if (isset($data['status']) && $data['status'] != 'all') {
            $status = explode(',', $data['status']);
            $employ = $employ->whereIn('employ.status', $status);
        }
        $employ = $employ->leftjoin('users as us', 'us.id', '=', 'employ.employee_uid')
            ->leftjoin('user_detail as ud', 'ud.uid', '=', 'employ.employee_uid')
            ->orderBy('created_at', 'DESC')
            ->paginate($paginate);

        return $employ;
    }

    
    static public function employMyJob($uid, $data,$paginate=5)
    {
        $employ = self::select('employ.*', 'us.name as user_name', 'ud.avatar')->where('employee_uid', $uid)->where('bounty_status', 1);

        if (isset($data['employ_type']) && $data['employ_type'] != 'all') {
            $employ = $employ->where('employ.employ_type', $data['employ_type']);
        }
        if (isset($data['time']) && $data['time'] != 'all') {
            $time = date('Y-m-d H:i:s', strtotime("-" . intval($data['time']) . " month"));
            $employ = $employ->where('employ.created_at', '>', $time);
        }
        if (isset($data['status']) && $data['status'] != 'all') {
            $status = explode(',', $data['status']);
            $employ = $employ->whereIn('employ.status', $status);
        }

        $employ = $employ->leftjoin('users as us', 'us.id', '=', 'employ.employer_uid')
            ->leftjoin('user_detail as ud', 'ud.uid', '=', 'employ.employer_uid')
            ->orderBy('created_at', 'DESC')
            ->paginate($paginate);

        return $employ;
    }
}
