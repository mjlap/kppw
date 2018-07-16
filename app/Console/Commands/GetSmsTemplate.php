<?php

namespace App\Console\Commands;

use App\Modules\Employ\Models\EmployModel;
use App\Modules\Manage\Model\ConfigModel;
use Illuminate\Console\Command;
use File;

class GetSmsTemplate extends Command
{
    
    protected $signature = 'GetSmsTemplate';

    
    protected $description = '获取程序中短信模板信息';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
        $registerCode = '';
        $findCode = '';
        $bindCode = '';
        $unBindCode = '';
        
        $scheme = $this->phpSmsConfig('phpsms_scheme');
        $registerPath = app_path().'/Modules/User/Http/Controllers/Auth/AuthController.php';
        $content = File::get($registerPath);
        $contentArr = $this->matching($content,$scheme,'];');
        if(!empty($contentArr)){
            $str = $contentArr[0];
            $code = $this->matching($str,$scheme."' => '","'");
            if(!empty($code) && isset($code[0])){
                $codeArr = explode('=>',$code[0]);
                if(isset($codeArr[1])){
                    $registerCode = $this->getNeedBetween($codeArr[1],"'","'");
                }
            }
        }
        
        $findPath = app_path().'/Modules/User/Http/Controllers/Auth/PasswordController.php';
        $content1 = File::get($findPath);
        $contentArr1 = $this->matching($content1,$scheme,'];');

        if(!empty($contentArr1)){
            $str1 = $contentArr1[0];
            $code1 = $this->matching($str1,$scheme."' => '","'");

            if(!empty($code1) && isset($code1[0])){
                $codeArr1 = explode('=>',$code1[0]);
                if(isset($codeArr1[1])){
                    $findCode = $this->getNeedBetween($codeArr1[1],"'","'");
                }
            }
        }
        
        $bindPath = app_path().'/Modules/User/Http/Controllers/AuthController.php';
        $content2 = File::get($bindPath);
        $contentArr2 = $this->matching($content2,$scheme,'];');
        if(!empty($contentArr2)){
            foreach($contentArr2 as $k => $v){
                if($k == 0 || $k = count($contentArr2)-1 ){
                    $code2 = $this->matching($v,$scheme."' => '","'");
                    if(!empty($code2) && isset($code2[0])){
                        $codeArr2 = explode('=>',$code2[0]);
                        if(isset($codeArr2[1])){
                            if($k == 0){
                                $bindCode = $this->getNeedBetween($codeArr2[1],"'","'");
                            }else{
                                $unBindCode = $this->getNeedBetween($codeArr2[1],"'","'");
                            }
                        }
                    }
                }

            }
        }
        $config = [
            'sendMobileCode' => $registerCode,
            'sendMobilePasswordCode' => $findCode,
            'sendBindSms' => $bindCode,
            'sendUnbindSms' => $unBindCode
        ];
        if(!empty($config)){
            foreach($config as $k => $v){
                if(!empty($v)){
                    $isExits = ConfigModel::where('alias',$k)->first();
                    if($isExits){
                        ConfigModel::where('alias',$k)->update(['rule' => $v]);
                    }else{
                        $newArr = [
                            'alias' => $k,
                            'rule' => $v,
                            'type' => 'phone'
                        ];
                        ConfigModel::create($newArr);
                    }
                }
            }
        }


        
        $schemeRule = config('phpsms.scheme');
        $schemeRule = (!empty($schemeRule) && is_array($schemeRule)) ? $schemeRule[0] : '';
        if(!empty($schemeRule)){

            $isExitsS = ConfigModel::where('alias','phpsms_scheme')->first();
            if($isExitsS){
                ConfigModel::where('alias','phpsms_scheme')->update(['rule' => $schemeRule]);
            }else{
                $newArr = [
                    'alias' => 'phpsms_scheme',
                    'rule' => $schemeRule,
                    'type' => 'phpsms'
                ];
                ConfigModel::create($newArr);
            }

            switch($schemeRule){
                case 'YunTongXun':
                    
                    $smsConfig = config('phpsms.agents.YunTongXun');
                    unset($smsConfig['serverIP'],$smsConfig['serverPort'],$smsConfig['displayNum'],$smsConfig['playTimes']);
                    break;
                case 'Alidayu':
                    
                    $smsConfig = config('phpsms.agents.Alidayu');
                    unset($smsConfig['calledShowNum']);
                    break;
                case 'Aliyun':
                    
                    $smsConfig = config('phpsms.agents.Aliyun');
                    break;
            }
            if(isset($smsConfig) && !empty($smsConfig)){
                $isExitsC = ConfigModel::where('alias','phpsms_config')->first();
                if($isExitsC){
                    ConfigModel::where('alias','phpsms_config')->update(['rule' => json_encode($smsConfig)]);
                }else{
                    $newArr = [
                        'alias' => 'phpsms_config',
                        'rule' => json_encode($smsConfig),
                        'type' => 'phpsms'
                    ];
                    ConfigModel::create($newArr);
                }
            }
        }

    }

    private function matching($str, $a, $b)
    {
        $pattern = '/('.$a.').*?('.$b.')/is';
        preg_match_all($pattern, $str, $m);
        
        return ($m[0]);
    }

    private function getNeedBetween($kw,$mark1,$mark2){
        $st = strpos($kw,$mark1);
        $ed = strripos($kw,$mark2);
        if(($st == false || $ed == false )||$st >= $ed){
            return 0;
        }
        $kw = substr($kw,($st+1),($ed-$st-1));
        return $kw;
    }

    private function phpSmsConfig($alias)
    {
        $arr = [
            'phpsms_scheme',
            'phpsms_config',
            'sendMobileCode',
            'sendMobilePasswordCode',
            'sendBindSms',
            'sendUnbindSms',
        ];
        if(!in_array($alias,$arr)){
            return false;
        }
        $config = ConfigModel::getConfigByAlias($alias);
        switch($alias){
            case 'phpsms_scheme':
                if($config && !empty($config['rule'])){
                    $rule = $config['rule'];
                }else{
                    $scheme = config('phpsms.scheme');
                    $rule = (!empty($scheme) && is_array($scheme)) ? $scheme[0] : '';
                }
                break;
            case 'phpsms_config':
                $rule = [];
                if($config && !empty($config['rule'])){
                    $rule = json_decode($config['rule'],true);
                }
                break;
            case 'sendMobileCode':
            case 'sendMobilePasswordCode':
            case 'sendBindSms':
            case 'sendUnbindSms':
                $rule = '';
                if($config && !empty($config['rule'])){
                    $rule = $config['rule'];
                }
                break;

        }
        return $rule;

    }
}
