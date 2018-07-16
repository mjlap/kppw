<?php
namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\BasicController;
use App\Modules\Manage\Model\ConfigModel;
use App\Modules\User\Http\Requests\AlipayAuthRequest;
use App\Modules\User\Http\Requests\EmailAuthRequest;
use App\Modules\User\Http\Requests\VerifyAlipayCashRequest;
use App\Modules\User\Http\Requests\VerifyBankCashRequest;
use App\Modules\User\Model\AlipayAuthModel;
use App\Modules\User\Model\BankAuthModel;
use App\Modules\User\Model\DistrictModel;
use App\Modules\User\Http\Requests\BankAuthRequest;
use App\Modules\User\Http\Requests\RealnameAuthRequest;
use App\Modules\User\Model\RealnameAuthModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\User\Model\UserModel;
use Illuminate\Http\Request;
use Auth;
use Crypt;
use Illuminate\Support\Facades\Session;

class EmailController extends BasicController
{

    public function __construct()
    {
        parent::__construct();

    }


    public function activeEmail($validationInfo)
    {
        if(Auth::check()){
            Auth::logout();
        }
        $info = Crypt::decrypt($validationInfo);
        $user = UserModel::where('email', $info['email'])->where('validation_code', $info['validationCode'])->first();

        $this->initTheme('auth');
        $this->theme->set('authAction', '欢迎注册');
        $this->theme->setTitle('欢迎注册');

        if ($user && time() > strtotime($user->overdue_date) || !$user) {
            return $this->theme->scope('user.activefail')->render();
        }

        $user->status = 1;
        $user->email_status = 2;
        $status = $user->save();
        if ($status){
            Auth::login($user);
            return $this->theme->scope('user.activesuccess')->render();
        }
    }



}