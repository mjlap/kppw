<?php

namespace App\Modules\User\Model;
use App\Modules\Finance\Model\FinancialModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use DB;

class PromoteModel extends Model
{
    protected $table = 'promote';

    public $timestamps = false;

    protected $fillable = [
        'id', 'from_uid','to_uid','price','finish_conditions','type','status','created_at','updated_at'
    ];

    
    public static function createPromoteUrl($uid)
    {
        $param = Crypt::encrypt($uid);
        $url = url('user/promote/'.$param);
        return $url;
    }


    
    public static function getUrlInfo($param)
    {
        $uid = Crypt::decrypt($param);
        return $uid;

    }


    
    public static function settlementByUid($uid)
    {
        
        $promote = PromoteModel::where('from_uid',$uid)->where('status',1)->get()->toArray();
        if(!empty($promote)){
            $realnameUid = array();
            $emailUid = array();
            $payUid = array();
            foreach($promote as $k => $v){
                if($v['finish_conditions'] == 1){
                    $realnameUid[] = $v['to_uid'];
                }
                if($v['finish_conditions'] == 2){
                    $emailUid[] = $v['to_uid'];
                }
                if($v['finish_conditions'] == 3){
                    $payUid[] = $v['to_uid'];
                }
            }
            if(!empty($realnameUid)){
                PromoteModel::getFinishPromoteByUid($uid,$realnameUid,1);
            }
            if(!empty($emailUid)){
                PromoteModel::getFinishPromoteByUid($uid,$emailUid,2);
            }
            if(!empty($payUid)){
                PromoteModel::getFinishPromoteByUid($uid,$payUid,3);
            }
        }else{
            return true;
        }
    }

    
    public static function getFinishPromoteByUid($uid,$toUid,$type)
    {
        switch($type){
            case 1:
                
                $res = RealnameAuthModel::whereIn('uid',$toUid)->where('status',1)->get()->toArray();
                if(!empty($res)){
                    $toUidArr = array();
                    foreach($res as $k => $v){
                        $toUidArr[] = $v['uid'];
                    }
                    if(!empty($toUidArr)){
                        $toUidArr = array_unique($toUid);
                        
                        PromoteModel::getFinishByUid($uid,$toUidArr);
                    }else{
                        return true;
                    }
                }else{
                    return true;
                }
                break;
            case 2:
                
                $res = UserModel::whereIn('id',$toUid)->where('email_status',2)->get()->toArray();
                if(!empty($res)){
                    $toUidArr = array();
                    foreach($res as $k => $v){
                        $toUidArr[] = $v['id'];
                    }
                    if(!empty($toUidArr)){
                        $toUidArr = array_unique($toUid);
                        
                        PromoteModel::getFinishByUid($uid,$toUidArr);
                    }else{
                        return true;
                    }
                }else{
                    return true;
                }
                break;
            case 3:
                
                $res = AuthRecordModel::where('uid',$toUid)->where('status',2)->whereIn('auth_code',['bank','alipay'])->get()->toArray();
                if(!empty($res)){
                    $toUidArr = array();
                    foreach($res as $k => $v){
                        $toUidArr[] = $v['uid'];
                    }
                    if(!empty($toUidArr)){
                        $toUidArr = array_unique($toUid);
                        
                        PromoteModel::getFinishByUid($uid,$toUidArr);
                    }else{
                        return true;
                    }
                }else{
                    return true;
                }
                break;
        }
    }

    
    public static function getFinishByUid($fromUid,$toUid)
    {
        $status = DB::transaction(function() use ($fromUid,$toUid){
            $price = PromoteModel::where('from_uid',$fromUid)->whereIn('to_uid',$toUid)->sum('price');
            
            UserDetailModel::where('uid', $fromUid)->increment('balance', $price);
            
            $financeData = [
                'action' => 14, 
                'pay_type' => 1,
                'cash' => $price,
                'uid' => $fromUid,
                'created_at' => date('Y-m-d H:i:s', time()),
            ];
            FinancialModel::create($financeData);
            $arr = array(
                'status' => 2,
                'updated_at' => date('Y-m-d H:i:s',time())
                );
            PromoteModel::where('from_uid',$fromUid)->whereIn('to_uid',$toUid)
                ->update($arr);
            return true;

        });
        return $status;

    }

    
    public static function createPromote($fromUid,$toUid)
    {
        
        $promoteType = PromoteTypeModel::where('is_open',1)->where('code_name','ZHUCETUIGUANG')->first();
        if($promoteType){
            $arr = array(
                'from_uid' => $fromUid,
                'to_uid' => $toUid,
                'price' => $promoteType->price,
                'finish_conditions' => $promoteType->finish_conditions,
                'type' => $promoteType->type,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s',time())
            );
            
            $res = PromoteModel::create($arr);
            return $res;
        }
        return false;
    }


}