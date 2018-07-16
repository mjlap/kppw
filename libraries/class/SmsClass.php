<?php

use Toplan\PhpSms\Sms;

/**
 * Created by PhpStorm.
 * User: kuke
 * Date: 2016/10/20
 * Time: 10:43
 */
class SmsClass
{


    /**
     * 发送短信
     *
     * @param $mobile
     * @param array $templates ['服务商' => 'temp_id']
     * @param array $data ['变量' => '值']
     * @param string $content
     * @return string
     */
    static function sendSms($mobile, $templates, $data, $content = '')
    {
        //容联云通讯配置信息
        $yunTongXun = config('phpsms.agents.YunTongXun');

        //阿里大鱼配置信息
        $alidayu = config('phpsms.agents.Alidayu');

        //阿里云通讯
        $aliyun = config('phpsms.agents.Aliyun');

        $phpsmsConfig = \App\Modules\Manage\Model\ConfigModel::getConfigByType('phpsms');
        if(isset($phpsmsConfig['phpsms_scheme']) && !empty($phpsmsConfig['phpsms_scheme'])){
            $scheme = $phpsmsConfig['phpsms_scheme'];
        }else{
            //配置类型
            $scheme = config('phpsms.scheme');
            $scheme = (!empty($scheme) && is_array($scheme)) ? $scheme[0] : '';
        }
        Sms::scheme([
            $scheme => '30',
        ]);
        switch($scheme){
            case 'YunTongXun':
                if(isset($phpsmsConfig['phpsms_config']) && !empty($phpsmsConfig['phpsms_config'])){
                    $yunTongXun = $phpsmsConfig['phpsms_config'];
                }
                Sms::config([
                    'YunTongXun' => [
                        'accountSid' => $yunTongXun['accountSid'],
                        'accountToken' => $yunTongXun['accountToken'],
                        'appId' => $yunTongXun['appId'],
                        'serverIP' => 'app.cloopen.com',
                        'serverPort' => '8883',
                        'softVersion' => '2013-12-26',
                        'displayNum' => null,
                        'voiceLang' => 'zh',
                        'playTimes' => 3,
                        'YunTongXun' => '76741',
                    ],

                ]);
                break;
            case 'Alidayu':
                if(isset($phpsmsConfig['phpsms_config']) && !empty($phpsmsConfig['phpsms_config'])){
                    $alidayu = $phpsmsConfig['phpsms_config'];
                }
                Sms::config([
                    'Alidayu' => [
                        //请求地址
                        'sendUrl' => $alidayu['sendUrl'],
                        //淘宝开放平台中，对应阿里大鱼短信应用的App Key
                        'appKey' => $alidayu['appKey'],
                        //淘宝开放平台中，对应阿里大鱼短信应用的App Secret
                        'secretKey' => $alidayu['secretKey'],
                        //短信签名，传入的短信签名必须是在阿里大鱼“管理中心-短信签名管理”中的可用签名
                        'smsFreeSignName' => $alidayu['smsFreeSignName'],
                        //被叫号显(用于语音通知)，传入的显示号码必须是阿里大鱼“管理中心-号码管理”中申请或购买的号码
                        'calledShowNum' => '400-077-325',
                    ],

                ]);
                break;
            case 'Aliyun':
                if(isset($phpsmsConfig['phpsms_config']) && !empty($phpsmsConfig['phpsms_config'])){
                    $aliyun = $phpsmsConfig['phpsms_config'];
                }
                Sms::config([
                    'Aliyun' => [
                        'accessKeyId'       => $aliyun['accessKeyId'],
                        'accessKeySecret'   => $aliyun['accessKeySecret'],
                        'signName'          => $aliyun['signName'],
                    ],

                ]);
                break;
        }

        $to = $mobile;
        
        $status = Sms::make()->to($to)->template($templates)->data($data)
            ->content($content)->send();
        return $status;
    }

}