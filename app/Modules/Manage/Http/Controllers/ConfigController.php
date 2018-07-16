<?php
namespace App\Modules\Manage\Http\Controllers;

use App\Http\Controllers\ManageController;
use App\Modules\Manage\Model\ConfigModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use Cache;
use Theme;


class ConfigController extends ManageController
{

    public function __construct()
    {
        parent::__construct();
        $this->initTheme('manage');
    }


    
    public function getConfigSite()
    {
        $this->theme->setTitle('站点配置');
        $config = ConfigModel::getConfigByType('site');
        $basisConfig = ConfigModel::getConfigByType('basis');
        $data = array(
            'site' => $config,
            'basic' => $basisConfig
        );
        return $this->theme->scope('manage.config.site', $data)->render();
    }

    
    public function saveConfigSite(Request $request)
    {
        $data = $request->except('_token', 'web_logo_1','web_logo_2');
        $config = ConfigModel::getConfigByType('site');

        $file1 = $request->file('web_logo_1');
        if ($file1) {
            
            $result1 = \FileClass::uploadFile($file1, 'sys');
            $result1 = json_decode($result1, true);
            $data['web_logo_1'] = $result1['data']['url'];
        }else{
            $data['web_logo_1'] = $config['site_logo_1'];
        }
        $file2 = $request->file('web_logo_2');
        if ($file2) {
            
            $result2 = \FileClass::uploadFile($file2, 'sys');
            $result2 = json_decode($result2, true);
            $data['web_logo_2'] = $result2['data']['url'];
        }else{
            $data['web_logo_2'] = $config['site_logo_2'];
        }
        $file3 = $request->file('wechat_pic');
        if ($file3) {
            
            $result3 = \FileClass::uploadFile($file3, 'sys');
            $result3 = json_decode($result3, true);
            $data['wechat_pic'] = $result3['data']['url'];
        }else{
            $data['wechat_pic'] = $config['wechat']['wechat_pic'];
        }
        $file4 = $request->file('browser_logo');
        if ($file4) {
            
            $ico = $file4->getClientOriginalExtension();
            if($ico != 'ico'){
                return redirect('/manage/config/site')->with(array('message' => '浏览器显示logo格式不对'));
            }
            $result4 = \FileClass::uploadFile($file4, 'sys');
            $result4 = json_decode($result4, true);
            $data['browser_logo'] = $result4['data']['url'];
        }else{
            $data['browser_logo'] = isset($config['browser_logo']) ? $config['browser_logo'] : '';
        }

        $siteRule = array(
            'site_name' => $data['web_site'],
            'site_url' => $data['web_url'],
            'site_logo_1' => $data['web_logo_1'],
            'site_logo_2' => $data['web_logo_2'],
            'browser_logo' => $data['browser_logo'],
            'company_name' => $data['company_name'],
            'company_address' => $data['company_address'],
            'record_number' => $data['site_record_code'],
            'copyright' => $data['footer_copyright'],
            'site_close' => $data['site_switch'],
            'phone' => $data['phone'],
            'Email' => $data['Email'],
            'site_version' => isset($data['site_version']) ? $data['site_version'] : 1
        );
        ConfigModel::updateConfig($siteRule);
        Cache::forget('site');
        $basicRule = array(
            'css_adaptive' => $data['css_adaptive'],
            'open_IM' => $data['open_IM'],
            'qq' => $data['customer_service_qq'],
            'IM_config' => json_encode(array(
                    'IM_ip' => $data['IM_ip'],
                    'IM_port' => $data['IM_port']
                )
            ),
        );
        ConfigModel::updateConfig($basicRule);
        Cache::forget('basis');
        return redirect('/manage/config/site')->with(array('message' => '保存成功'));
    }

    
    public function getConfigEmail()
    {
        $this->theme->setTitle('邮箱配置');
        
        $mailEncryption = \CommonClass::findEnvInfo('MAIL_ENCRYPTION');
        if(empty($mailEncryption)){
            $mailEncryption = config('mail.encryption');
        }
        
        $mailHost = \CommonClass::findEnvInfo('MAIL_HOST');
        
        $mailPort = \CommonClass::findEnvInfo('MAIL_PORT');
        
        $mailUsername = \CommonClass::findEnvInfo('MAIL_USERNAME');
        
        $mailPassword = \CommonClass::findEnvInfo('MAIL_PASSWORD');
        
        $mailFromAddress = \CommonClass::findEnvInfo('MAIL_FROM_ADDRESS');
        $mailFromName = \CommonClass::findEnvInfo('MAIL_FROM_NAME');
        $testEmail = \CommonClass::findEnvInfo('MAIL_TEST');
        $email = array(
            'mail_encryption' => $mailEncryption,
            'send_mail_server' => $mailHost,
            'server_port' => $mailPort,
            'email_account' => $mailUsername,
            'account_password' => $mailPassword,
            'reply_email_address' => $mailFromAddress,
            'reply_email_name' => $mailFromName,
            'test_email_address' => $testEmail
        );
        $data = array(
            'email' => $email
        );
        return $this->theme->scope('manage.config.email', $data)->render();
    }

    
    public function saveConfigEmail(Request $request)
    {
        $data = $request->except('_token');

        $validator = Validator::make($request->all(), [
            'mail_encryption' => 'required',
            'send_mail_server' => 'required',
            'server_port' => 'required',
            'email_account' => 'required',
            'account_password' => 'required',
            'reply_email_name' => 'required',
        ],[
            'mail_encryption.required' => '请选择是否启用加密连接(SSL)',
            'send_mail_server.required' => '请输入邮件发送服务器',
            'server_port.required' => '请输入服务器端口',
            'email_account.required' => '请输入发送邮件账号',
            'account_password.required' => '请输入账号密码',
            'reply_email_name.required' => '请输入邮件回复名称',
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return  redirect('/manage/config/email')->with(array('message' => $error[0]));
        }

        $configData = [
            'MAIL_ENCRYPTION' => $data['mail_encryption'] ? trim($data['mail_encryption']) : 'tls',
            'MAIL_HOST' => $data['send_mail_server'] ? trim($data['send_mail_server']) : '',
            'MAIL_PORT' => $data['server_port'] ? trim($data['server_port']) : 25,
            'MAIL_USERNAME' => $data['email_account'] ? trim($data['email_account']) : '',
            'MAIL_PASSWORD' => $data['account_password'] ? trim($data['account_password']) : '',
            'MAIL_FROM_ADDRESS' => $data['reply_email_address'] ? trim($data['reply_email_address']) : '',
            'MAIL_FROM_NAME' => $data['reply_email_name'] ?  trim($data['reply_email_name']) : '',
            'MAIL_TEST' => $data['test_email_address'] ? trim($data['test_email_address']) : ''
        ];
        foreach ($configData as $key => $value){
            $path = base_path('.env');
            $originStr = file_get_contents($path);
            if(strstr($originStr,$key)){
                $str = $key . "=" . $value;
                $res = \CommonClass::checkEnvIsNull($key);
                if($res){
                    $newStr = $key."=".env($key);
                }else{
                    if(\CommonClass::findEnvInfo($key)){
                        $newStr = $key.'='.\CommonClass::findEnvInfo($key);
                    }else{
                        $newStr = $key.'=';
                    }
                }
                $updateStr = str_replace($newStr,$str,$originStr);
                file_put_contents($path,$updateStr);
            }else{
                $str = "\n" .$key . "=" . $value;
                file_put_contents($path,$str,FILE_APPEND);
            }
        }
        return redirect('/manage/config/email')->with(array('message' => '保存成功'));


    }

    
    public function getConfigBasic()
    {
        $this->theme->setTitle('基本配置');
        $config = ConfigModel::getConfigByType('basis');
        $data = array(
            'basic' => $config
        );
        return $this->theme->scope('manage.config.basic', $data)->render();
    }

    
    public function saveConfigBasic(Request $request)
    {
        $data = $request->except('_token');
        $basicRule = array(
          

            'css_adaptive' => $data['css_adaptive'],
            'open_IM' => $data['open_IM'],
            'qq' => $data['customer_service_qq'],
           

        );
        ConfigModel::updateConfig($basicRule);
        return redirect('/manage/config/basic')->with(array('message' => '保存成功'));
    }

    
    public function getConfigSEO()
    {
        $this->theme->setTitle('seo配置');
        $seoConfig = ConfigModel::getConfigByType('seo');
        $data = array(
            'seo' => $seoConfig
        );
        return $this->theme->scope('manage.config.seo', $data)->render();
    }

    
    public function saveConfigSEO(Request $request)
    {
        $data = $request->except('taken');
        $seoRule = array(
          

            'seo_index' => json_encode(array(
                'title' => $data['homepage_seo_title'],
                'keywords' => $data['homepage_seo_keywords'],
                'description' => $data['homepage_seo_desc']
            )),
            'seo_task' => json_encode(array(
                'title' => $data['task_seo_title'],
                'keywords' => $data['task_seo_keywords'],
                'description' => $data['task_seo_desc']
            )),
            'seo_service' => json_encode(array(
                'title' => $data['service_seo_title'],
                'keywords' => $data['service_seo_keywords'],
                'description' => $data['service_seo_desc']
            )),
            'seo_article' => json_encode(array(
                'title' => $data['article_seo_title'],
                'keywords' => $data['article_seo_keywords'],
                'description' => $data['article_seo_desc']
            )),
        );
        ConfigModel::updateConfig($seoRule);
        Cache::forget('seo');
        return redirect('/manage/config/seo')->with(array('message' => '保存成功'));
    }


    
    public function getConfigNav()
    {
        
        $navigation = NavigationModel::getAll();
        $data = array(
            'data' => $navigation
        );
        return $this->theme->scope('manage.config.nav', $data)->render();
    }

    public function deleteConfigNav($id)
    {
        
        NavigationModel::deleteNavigation($id);
        return redirect()->to('/manage/config/nav')->with(['massage'=>'删除成功！']);
    }

    public function postConfigNav(Request $request)
    {
        
        NavigationModel::updateConfigNav($request->all());
        return redirect('/manage/config/nav');
    }

    
    public function getAttachmentConfig()
    {
        $this->theme->setTitle('附件配置');
        $config = ConfigModel::getConfigByType('attachment');

        $data = [
            'config' => $config
        ];
        return $this->theme->scope('manage.config.attachment', $data)->render();
    }

    
    public function postAttachmentConfig(Request $request)
    {
        $data = $request->except('_token');
        ConfigModel::updateConfig($data);
        Cache::forget('attachment');
        return redirect('manage/config/attachment')->with(['message' => '操作成功']);
    }

    
    public function sendEmail(Request $request)
    {
        $email = $request->get('email');
        if(empty($email)){
            $data = array(
                'code' => 0,
                'msg' => '缺少测试邮箱地址'
            );
        }else{
            $flag = Mail::raw('这是一封测试邮件', function ($message) use ($email) {
                $to = $email;
                $message ->to($to)->subject('测试邮件');
            });
            if($flag == 1){
                $data = array(
                    'code' => 1,
                    'msg' => '发送邮件成功，请查收！'
                );
            }else{
                $data = array(
                    'code' => 0,
                    'msg' => '发送邮件失败，请重试！'
                );
            }
        }
        return response()->json($data);

    }
    public function aboutUs()
    {
        $this->theme->setTitle('关于我们');

        return $this->theme->scope('manage.config.aboutus')->render();
    }

    
    public function configLink()
    {
        $this->theme->setTitle('关注链接');
        $config = ConfigModel::getConfigByType('site');
        $data = array(
            'site' => $config,
        );
        return $this->theme->scope('manage.config.link',$data)->render();
    }

    public function link(Request $request)
    {
        $data = $request->except('_token');
        $config = ConfigModel::getConfigByType('site');
        $file3 = $request->file('wechat_pic');
        if ($file3) {
            
            $result3 = \FileClass::uploadFile($file3, 'sys');
            $result3 = json_decode($result3, true);
            $data['wechat_pic'] = $result3['data']['url'];
        }else{
            $data['wechat_pic'] = $config['wechat']['wechat_pic'];
        }
        $siteRule = array(
            'statistic_code' => $data['third_party_code'],
            'sina' =>  json_encode(array(
                    'sina_url' => $data['sina_url'],
                    'sina_switch' => $data['sina_switch']
                )
            ),
            'tencent' => json_encode(array(
                    'tencent_url' => $data['tencent_url'],
                    'tencent_switch' => $data['tencent_switch']
                )
            ),
            'wechat' => json_encode(array(
                    'wechat_pic' => $data['wechat_pic'],
                    'wechat_switch' => $data['wechat_switch']
                )
            ),
        );
        ConfigModel::updateConfig($siteRule);
        Cache::forget('site');
        return redirect('/manage/config/link')->with(array('message' => '保存成功'));
    }

    
    public function getConfigPhone()
    {
        $this->theme->setTitle('短信配置');

        
        $yunTongXun = config('phpsms.agents.YunTongXun');

        
        $alidayu = config('phpsms.agents.Alidayu');

        
        $aliyun = config('phpsms.agents.Aliyun');

        $phpsmsConfig = ConfigModel::getConfigByType('phpsms');
        if(isset($phpsmsConfig['phpsms_scheme']) && !empty($phpsmsConfig['phpsms_scheme'])){
            $scheme = $phpsmsConfig['phpsms_scheme'];
        }else{
            
            $scheme = config('phpsms.scheme');
            $scheme = (!empty($scheme) && is_array($scheme)) ? $scheme[0] : '';
        }
        switch($scheme){
            case 'YunTongXun':
                if(isset($phpsmsConfig['phpsms_config']) && !empty($phpsmsConfig['phpsms_config'])){
                    $yunTongXun = $phpsmsConfig['phpsms_config'];
                }
                break;
            case 'Alidayu':
                if(isset($phpsmsConfig['phpsms_config']) && !empty($phpsmsConfig['phpsms_config'])){
                    $alidayu = $phpsmsConfig['phpsms_config'];
                }
                break;
            case 'Aliyun':
                if(isset($phpsmsConfig['phpsms_config']) && !empty($phpsmsConfig['phpsms_config'])){
                    $aliyun = $phpsmsConfig['phpsms_config'];
                }
                break;
        }
        $sendMobileCode = '';
        $sendMobilePasswordCode = '';
        $sendBindSms = '';
        $sendUnbindSms = '';
        $config =  ConfigModel::where('type','phone')->get()->toArray();
        if(!empty($config)){
            foreach($config as $k => $v){
                switch($v['alias']){
                    case 'sendMobileCode':
                        $sendMobileCode = $v['rule'];
                        break;
                    case 'sendMobilePasswordCode':
                        $sendMobilePasswordCode = $v['rule'];
                        break;
                    case 'sendBindSms':
                        $sendBindSms = $v['rule'];
                        break;
                    case 'sendUnbindSms':
                        $sendUnbindSms = $v['rule'];
                        break;
                }
            }
        }

        $phone = array(
            'scheme' => $scheme,
            'yunTongXun' => $yunTongXun,
            'alidayu' => $alidayu,
            'aliyun' => $aliyun,
        );
        $data = array(
            'phone' => $phone,
            'sendMobileCode' => $sendMobileCode,
            'sendMobilePasswordCode' => $sendMobilePasswordCode,
            'sendBindSms' => $sendBindSms,
            'sendUnbindSms' => $sendUnbindSms
        );
        return $this->theme->scope('manage.config.phone', $data)->render();
    }

    
    public function saveConfigPhone(Request $request)
    {
        $data = $request->except('_token');
        if(!isset($data['scheme']) || empty($data['scheme'])){
            return  redirect('/manage/config/phone')->with(array('message' => '请选择短信服务商'));
        }
        $configData = [];
        switch($data['scheme']){
            case 'YunTongXun' :
                $validator = Validator::make($data, [
                    'accountSid' => 'required',
                    'accountToken' => 'required',
                    'appId' => 'required',

                ],[
                    'accountSid.required' => '请填写主帐号',
                    'accountToken.required' => '请填写主帐号令牌',
                    'appId.required' => '请填写应用Id',

                ]);
                $error = $validator->errors()->all();
                if(count($error)){
                    return  redirect('/manage/config/phone')->with(array('message' => $error[0]));
                }
                $configData = [
                    
                    'accountSid' => $data['accountSid'] ? trim($data['accountSid']) : '',
                    'accountToken' => $data['accountToken'] ? trim($data['accountToken']) : '',
                    'appId' => $data['appId'] ? trim($data['appId']) : '',

                ];
                break;
            case 'Alidayu' :
                $validator = Validator::make($data, [
                    'sendUrl' => 'required',
                    'appKey' => 'required',
                    'secretKey' => 'required',
                    'smsFreeSignName' => 'required',

                ],[
                    'sendUrl.required' => '请填写请求地址',
                    'appKey.required' => '请填写appKey',
                    'secretKey.required' => '请填写secretKey',
                    'smsFreeSignName.required' => '请填写短信签名',
                ]);
                $error = $validator->errors()->all();
                if(count($error)){
                    return  redirect('/manage/config/phone')->with(array('message' => $error[0]));
                }
                $configData = [
                    
                    'sendUrl' => $data['sendUrl'] ? trim($data['sendUrl']) : '',
                    'appKey' => $data['appKey'] ? trim($data['appKey']) : '',
                    'secretKey' => $data['secretKey'] ?  trim($data['secretKey']) : '',
                    'smsFreeSignName' => $data['smsFreeSignName'] ? trim($data['smsFreeSignName']) : '',
                ];
                break;
            case 'Aliyun' :
                $validator = Validator::make($data, [
                    'accessKeyId' => 'required',
                    'accessKeySecret' => 'required',
                    'signName' => 'required',
                ],[
                    'accessKeyId.required' => '请填写accessKeyId',
                    'accessKeySecret.required' => '请填写accessKeySecret',
                    'signName.required' => '请填写短信签名',
                ]);
                $error = $validator->errors()->all();
                if(count($error)){
                    return  redirect('/manage/config/phone')->with(array('message' => $error[0]));
                }
                $configData = [
                    
                    'accessKeyId' => $data['accessKeyId'] ? trim($data['accessKeyId']) : '',
                    'accessKeySecret' => $data['accessKeySecret'] ? trim($data['accessKeySecret']) : '',
                    'signName' => $data['signName'] ? trim($data['signName']) : '',
                ];
                break;
        }
        $arr = [
            'sendMobileCode' => $data['sendMobileCode'] ? trim($data['sendMobileCode']) : '',
            'sendMobilePasswordCode' => $data['sendMobilePasswordCode'] ? trim($data['sendMobilePasswordCode']) : '',
            'sendBindSms' => $data['sendBindSms'] ?  trim($data['sendBindSms']) : '',
            'sendUnbindSms' => $data['sendUnbindSms'] ? trim($data['sendUnbindSms']) : '',
        ];
        $count = 0;
        $total = 0;
        if(!empty($arr)){
            foreach($arr as $k => $v) {
                if(!empty($v)){
                    $total = $total + 1;
                    $isExits = ConfigModel::where('alias',$k)->first();
                    if($isExits){
                        $r = ConfigModel::where('alias',$k)->update(['rule' => $v]);
                        if($r){
                            $count = $count +1;
                        }
                    }else{
                        $newArr = [
                            'alias' => $k,
                            'rule' => $v,
                            'type' => 'phone'
                        ];
                        $r = ConfigModel::create($newArr);
                        if($r){
                            $count = $count +1;
                        }
                    }
                }

            }
        }
       


        
        $isExitsS = ConfigModel::where('alias','phpsms_scheme')->first();
        if($isExitsS){
            ConfigModel::where('alias','phpsms_scheme')->update(['rule' => trim($data['scheme'])]);
        }else{
            $newArrS = [
                'alias' => 'phpsms_scheme',
                'rule' => trim($data['scheme']),
                'type' => 'phpsms'
            ];
            ConfigModel::create($newArrS);
        }

        if(!empty($configData)){
            

            
            $configData = json_encode($configData);
            $isExitsC = ConfigModel::where('alias','phpsms_config')->first();
            if($isExitsC){
                ConfigModel::where('alias','phpsms_config')->update(['rule' => $configData]);
            }else{
                $newArrS = [
                    'alias' => 'phpsms_config',
                    'rule' => $configData,
                    'type' => 'phpsms'
                ];
                ConfigModel::create($newArrS);
            }
            Cache::forget('phpsms');
            return redirect('/manage/config/phone')->with(array('message' => '保存成功'));

        }

        return redirect('/manage/config/phone')->with(array('message' => '保存失败'));

    }

    
    public function getConfigAppAliPay()
    {
        $this->theme->setTitle('app支付宝支付配置');

        
        $partner_id = config('latrell-alipay.partner_id');
        
        $seller_id = config('latrell-alipay.seller_id');
        
        $key = config('latrell-alipay-mobile.key');

        $config = ConfigModel::getConfigByAlias('app_alipay');
        if($config && !empty($config['rule'])){
            $info = json_decode($config['rule'],true);
            $partner_id = $info['partner_id'];
            $seller_id = $info['seller_id'];
            $key = $info['key'];
        }
        $isPrivate = false;
        $isPublic = false;
        
        $private_key_path = storage_path('app/alipay/rsa_private_key.pem');
        if(file_exists($private_key_path)){
            $isPrivate = true;
        }
        
        $public_key_path = storage_path('app/alipay/rsa_public_key.pem');
        if(file_exists($public_key_path)){
            $isPublic = true;
        }
       
        $data = array(
            'partner_id' => $partner_id,
            'seller_id' => $seller_id,
            'key' => $key,
            'private_key_path' => $private_key_path,
            'public_key_path' => $public_key_path,
            'isPrivate' => $isPrivate,
            'isPublic' => $isPublic
        );
        return $this->theme->scope('manage.config.appalipay', $data)->render();
    }

    
    public function saveConfigAppAliPay(Request $request)
    {
        $data = $request->except('_token');

        $validator = Validator::make($data, [
            'partner_id' => 'required',
            'seller_id' => 'required',
            'key' => 'required',
            'private_key_path' => 'required',
            'public_key_path' => 'required',
        ],[
            'partner_id.required' => '请填写合作身份者id',
            'seller_id.required' => '请填写卖家支付宝帐户',
            'key.required' => '请填写安全检验码',
            'private_key_path.required' => '请上传商户私钥',
            'public_key_path.required' => '请上传阿里私钥'
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return  redirect('/manage/config/appalipay')->with(array('message' => $error[0]));
        }

        $configData = [
            'partner_id' => $data['partner_id'] ? trim($data['partner_id']) : '',
            'seller_id' => $data['seller_id'] ? trim($data['seller_id']) : '',
            'key' => $data['key'] ?  trim($data['key']) : '',
        ];

        $configData = json_encode($configData);
        
        $isExitsS = ConfigModel::where('alias','app_alipay')->first();
        if($isExitsS){
            $rr = ConfigModel::where('alias','app_alipay')->update(['rule' => $configData]);
        }else{
            $newArrS = [
                'alias' => 'app_alipay',
                'rule' => $configData,
                'type' => 'thirdpay'
            ];
            $rr = ConfigModel::create($newArrS);
        }

        
        $path = storage_path().'/app/alipay';
        $privatefile = $request->file('private_key_path');
        $privatefileName = $privatefile->getClientOriginalName();
        $publicfile = $request->file('public_key_path');
        $publicfileName = $publicfile->getClientOriginalName();

        $uploadArr = [
            'private_key_path' => [
                $privatefile,
                $privatefileName
            ],
            'public_key_path' => [
                $publicfile,
                $publicfileName
            ]
        ];
        $count = 0;
        foreach($uploadArr as $k => $v){
            if(is_uploaded_file($_FILES[$k]['tmp_name'])){
                if(file_exists($path.'/'.$v[1])){
                    
                    unlink($path.'/'.$v[1]);
                }
                $res = \FileClass::uploadFileToDir($v[0]);
                $res = json_decode($res,true);
                if($res['code'] == 200){
                    $count = $count + 1;
                }
            }
        }

        if(!$rr && $count < 2){
            return redirect('/manage/config/appalipay')->with(array('message' => '保存失败'));
        }else{
            return redirect('/manage/config/appalipay')->with(array('message' => '保存成功'));
        }
    }


    
    public function getConfigAppWeChat()
    {
        $this->theme->setTitle('app微信支付配置');


        $wechatConfig = config('laravel-omnipay.gateways.WechatPay.options');
        $config = ConfigModel::getConfigByAlias('app_wechat');
        if($config && !empty($config['rule'])){
            $wechatConfig = json_decode($config['rule'],true);

        }

        $data = array(
            'wechat' => $wechatConfig
        );
        return $this->theme->scope('manage.config.appwechat', $data)->render();
    }

    
    public function saveConfigAppWeChat(Request $request)
    {
        $data = $request->except('_token');

        $validator = Validator::make($data, [
            'appId' => 'required',
            'apiKey' => 'required',
            'mchId' => 'required',
        ],[
            'appId.required' => '请填写appId',
            'apiKey.required' => '请填写apiKey',
            'mchId.required' => '请填写mchId',
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return  redirect('/manage/config/appwechat')->with(array('message' => $error[0]));
        }

        $configData = [
            'appId' => $data['appId'] ? trim($data['appId']) : '',
            'apiKey' => $data['apiKey'] ? trim($data['apiKey']) : '',
            'mchId' => $data['mchId'] ?  trim($data['mchId']) : '',
        ];

        $configData = json_encode($configData);
        
        $isExitsS = ConfigModel::where('alias','app_wechat')->first();
        if($isExitsS){
            ConfigModel::where('alias','app_wechat')->update(['rule' => $configData]);
        }else{
            $newArrS = [
                'alias' => 'app_wechat',
                'rule' => $configData,
                'type' => 'thirdpay'
            ];
            ConfigModel::create($newArrS);
        }
        return redirect('/manage/config/appwechat')->with(array('message' => '保存成功'));
    }


    
    public function getConfigWeChatPublic()
    {
        $this->theme->setTitle('微信端配置');


        $appId = config('wechat-public.app_id');
        $secret = config('wechat-public.secret');
        $token = config('wechat-public.token');
        $aesKey = config('wechat-public.aes_key');
        $wechatConfig = [
            'app_id'  => $appId,
            'secret'  => $secret,
            'token'   => $token,
            'aes_key' => $aesKey
        ];
        $config = ConfigModel::getConfigByAlias('wechat_public');
        if($config && !empty($config['rule'])){
            $wechatConfig = json_decode($config['rule'],true);

        }

        $data = array(
            'wechat' => $wechatConfig
        );
        return $this->theme->scope('manage.config.wechatpublic', $data)->render();
    }

    public function saveConfigWeChatPublic(Request $request)
    {
        $data = $request->except('_token');

        $validator = Validator::make($data, [
            'app_id' => 'required',
            'secret' => 'required',
            'token' => 'required',
        ],[
            'app_id.required' => '请填写app_id',
            'secret.required' => '请填写secret',
            'token.required' => '请填写token',
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return  redirect('/manage/config/wechatpublic')->with(array('message' => $error[0]));
        }

        $configData = [
            'app_id' => $data['app_id'] ? trim($data['app_id']) : '',
            'secret' => $data['secret'] ? trim($data['secret']) : '',
            'token' => $data['token'] ?  trim($data['token']) : '',
            'aes_key' => $data['aes_key'] ?  trim($data['aes_key']) : '',
        ];

        $configData = json_encode($configData);
        
        $isExitsS = ConfigModel::where('alias','wechat_public')->first();
        if($isExitsS){
            ConfigModel::where('alias','wechat_public')->update(['rule' => $configData]);
        }else{
            $newArrS = [
                'alias' => 'wechat_public',
                'rule' => $configData,
                'type' => 'wechat_public',
                'title' => '微信端配置',
            ];
            ConfigModel::create($newArrS);
        }
        return redirect('/manage/config/wechatpublic')->with(array('message' => '保存成功'));
    }

    
    function getNeedBetween($kw1,$mark1,$mark2){
        $kw = $kw1;
        $st = strpos($kw,$mark1);
        $new = strstr($kw,$mark1);
        $ed = strpos($new,$mark2);
        $ed = $st + $ed;
        if(($st == false || $ed == false )||$st >= $ed){
            return 0;
        }
        $kw = substr($kw,($st+1),($ed-$st-1));
        return $kw;
    }

    function getNeedStrBetween($kw1,$mark1,$mark2){
        $kw = $kw1;
        $st = strpos($kw,$mark1);
        $new = strstr($kw,$mark1);
        $ed = strpos($new,$mark2);
        $ed = $st + $ed;
        if(($st === false || $ed === false )||$st >= $ed){
            return 0;
        }
        $kw = substr($kw,($st+strlen($mark1)),($ed-$st-strlen($mark2)-2));
        return $kw;
    }
}