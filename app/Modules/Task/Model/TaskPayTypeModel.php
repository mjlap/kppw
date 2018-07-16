<?php

namespace App\Modules\Task\Model;

use App\Modules\Manage\Model\ConfigModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\User\Model\UserModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class TaskPayTypeModel extends Model
{
    protected $table = 'task_pay_type';
    public  $timestamps = false;  
    public $fillable = ['id','task_id','pay_type','pay_type_append','status','created_at','updated_at'];

    
    static public function saveTaskPayType($data)
    {
        $status = DB::transaction(function () use ($data) {
            $payTypeInfo = [
                'task_id' => $data['task_id'],
                'pay_type' => $data['pay_type'],
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            if($data['pay_type'] == 4){
                $payTypeInfo['pay_type_append'] = $data['pay_type_append'];
            }else{
                $payTypeInfo['pay_type_append'] = '';
            }
            TaskPayTypeModel::create($payTypeInfo);

            $sort = $data['sort'];
            $percent = $data['percent'];
            $price = $data['price'];
            $desc = $data['desc'];
            if(is_array($sort) && !empty($sort)){
                for ($i = 0; $i < count($sort); $i++) {
                    $paySectionInfo[] = array(
                        'task_id' => $data['task_id'],
                        'sort' => $sort[$i],
                        'percent' => $percent[$i],
                        'name' => '第'.$sort[$i].'阶段',
                        'price' => $price[$i],
                        'desc' => $desc[$i],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                }
                if (!empty($paySectionInfo)) {
                    TaskPaySectionModel::insert($paySectionInfo);
                }
            }
        });

        return is_null($status) ? true : false;
    }


    
    static public function checkTaskPayType($taskId,$type,$uid)
    {
        $status = DB::transaction(function () use ($taskId,$type,$uid) {
            TaskPayTypeModel::where('task_id',$taskId)->update(['status' => $type,'updated_at' => date('Y-m-d H:i:s')]);
            TaskPaySectionModel::where('task_id',$taskId)->update(['case_status' => $type,'uid'=> $uid,'updated_at' => date('Y-m-d H:i:s')]);
            if($type == 1){
                
                $task = TaskModel::find($taskId);
                if($task['kee_status'] == 1){
                    
                    $res = self::loadKee($taskId,$uid);
                    if($res){
                        $arrData = [
                            'checked_at' =>date('Y-m-d H:i:s',time()),
                            'kee_status' => 2,
                        ];
                    }else{
                        $arrData = [
                            'checked_at' =>date('Y-m-d H:i:s',time()),
                            'kee_status' => 3,
                        ];
                    }
                }else{
                    $arrData = [
                        'checked_at' =>date('Y-m-d H:i:s',time()),
                    ];
                }

                TaskModel::where('id', $taskId)->update($arrData);
            }
        });

        return is_null($status) ? true : false;
    }

    
    static public function loadKee($taskId,$uid)
    {
        $keeKeyRule = ConfigModel::where('alias', 'kee_key')->first();
        if($keeKeyRule){
            $keeKey = $keeKeyRule['rule'];
        }else{
            $keeKey = '';
        }
        if($keeKey){
            $task = TaskModel::find($taskId);
            $pubUser = UserModel::where('id', $task['uid'])->first();
            $reUser = UserModel::where('id', $uid)->first();
            $section  = [];
            
            $taskSection = TaskPaySectionModel::where('task_id', $taskId)->select('sort', 'percent', 'name','desc')->orderBy('sort','asc')->get()->toArray();
            if (!empty($taskSection)) {
                foreach ($taskSection as $k => $v) {
                    $section[$k]['sectionName'] = $v['name'];
                    $section[$k]['content'] = $v['desc'];
                    $section[$k]['percentage'] = $v['percent'] . '%';
                    $section[$k]['startDate'] = '';
                    $section[$k]['endDate'] = '';
                }
            }
            $url = \CommonClass::getConfig('kee_path').'KPPWImportProject';
            $data = [
                'project' => [
                    'id' => $taskId,
                    'name' => isset($task['title']) ? $task['title'] : '',
                    'money' => isset($task['bounty']) ? $task['bounty'] : '',
                    'remark' => ''
                ],
                'user' => [
                    'vipUser' => [ 
                        'id' => $uid,
                        'name' => isset($reUser['name']) ? $reUser['name'] : '',
                        'email' => isset($reUser['email']) ? $reUser['email'] : '',
                        'mobile' => isset($reUser['mobile']) ? $reUser['mobile'] : '',
                    ],
                    'employerUser' => [ 
                        'id' => isset($task['uid']) ? $task['uid'] : '',
                        'name' => isset($pubUser['name']) ? $pubUser['name'] : '',
                        'email' => isset($pubUser['email']) ? $pubUser['email'] : '',
                        'mobile' => isset($pubUser['mobile']) ? $pubUser['mobile'] : '',
                    ],
                ],
                'key' => $keeKey,
                'section' => $section
            ];
            $result = json_decode(\CommonClass::sendPostRequest($url,json_encode($data)),true);
            if($result['code'] == 1000){
                return true;
            }else{
                return false;
            }
        }
    }


    
    static public function toKeeLook($id, $username, $userStaue = 4)
    {
        $isLoadKee = self::where('task_id', $id)->first();
        if (!empty($isLoadKee)) {
            
            $keeKeyRule = ConfigModel::where('alias', 'kee_key')->first();
            if ($keeKeyRule) {
                $keeKey = $keeKeyRule['rule'];
            } else {
                $keeKey = '';
            }
            if (!empty($keeKey)) {

                $url = \CommonClass::getConfig('kee_path') . 'KPPWCreateUUID';
                $result = json_decode(\CommonClass::sendGetRequest($url), true);
                if ($result['code'] == 1000) {
                    
                    $uuid = self::autocode($result['uuid'], 'ENCODE', 'kppwToKee1234', 0);
                    $data = [
                        'key' => $keeKey,
                        'uuid' => $uuid,
                        'username' => $username,
                        'userStaue' => $userStaue,
                        'comType' => 1,
                        'organizeSN'=>$isLoadKee['task_id']
                    ];
                    $verifyUrl = \CommonClass::getConfig('kee_path') . 'KPPWVerifyUser';
                    $res = json_decode(\CommonClass::sendPostRequest($verifyUrl, json_encode($data)), true);
                    if ($res['code'] == 1000) {
                        return $res['url'];
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    
    static function autocode($string,$operation = 'DECODE',$key='',$expiry=0)
    {
        $ckey_length = 4;

        $key = md5($key);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }




}
