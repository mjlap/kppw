<?php
namespace App\Modules\Manage\Http\Controllers;

use App\Http\Controllers\BasicController;
use App\Http\Controllers\ManageController;
use App\Modules\Task\Model\TaskCateModel;
use App\Modules\User\Model\AlipayAuthModel;
use App\Modules\User\Model\AuthRecordModel;
use App\Modules\User\Model\BankAuthModel;
use App\Modules\User\Model\EnterpriseAuthModel;
use App\Modules\User\Model\RealnameAuthModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ManageController
{
    public function __construct()
    {
        parent::__construct();

        $this->initTheme('manage');
        $this->theme->setTitle('认证管理');
        $this->theme->set('manageType', 'auth');
    }


    
    public function realnameAuth($id)
    {
        $id = intval($id);
        $realnameInfo = RealnameAuthModel::where('id', $id)->first();
        if (!empty($realnameInfo)) {
            $data = array(
                'realname' => $realnameInfo
            );
            return $this->theme->scope('manage.realnameauthinfo', $data)->render();
        }
    }

    
    public function realnameAuthList(Request $request)
    {
        $merge = $request->all();
        $realNameList = RealnameAuthModel::whereRaw('1=1');
        
        if ($request->get('username')) {
            $realNameList = $realNameList->where('username','like','%' . $request->get('username') . '%');
        }
        
        if ($request->get('real_name')) {
            $realNameList = $realNameList->where('realname','like','%' . $request->get('real_name') . '%');
        }
        
        if ($request->get('status')) {
            switch($request->get('status')){
                case 1:
                    $status = 0;
                    $realNameList = $realNameList->where('status',$status);
                    break;
                case 2:
                    $status = 1;
                    $realNameList = $realNameList->where('status',$status);
                    break;
                case 3:
                    $status = 2;
                    $realNameList = $realNameList->where('status',$status);
                    break;
            }
        }
        
        if($request->get('time_type')){
            $timeType = $request->get('time_type');
            if($request->get('start')){
                $start = date('Y-m-d H:i:s',strtotime($request->get('start')));
                $realNameList = $realNameList->where($timeType,'>',$start);

            }
            if($request->get('end')){
                $end = date('Y-m-d H:i:s',strtotime($request->get('end')));
                $realNameList = $realNameList->where($timeType,'<',$end);
            }

        }

        $by = $request->get('by') ? $request->get('by') : 'id';
        $order = $request->get('order') ? $request->get('order') : 'desc';
        $paginate = $request->get('paginate') ? $request->get('paginate') : 10;

        $realNameList = $realNameList->orderBy($by, $order)->paginate($paginate);


        $data = array(
            'merge' => $merge,
            'realname' => $realNameList,
        );


        $this->breadcrumb->add(array(
            array(
                'label' => '实名认证',
                'url' => '/manage/realnameAuthList'
            ),
            array(
                'label' => '认证列表'
            )
        ));
        $this->theme->set('manageAction', 'realname');
        return $this->theme->scope('manage.realnamelist', $data)->render();
    }


    
    public function realnameAuthHandle($id, $action)
    {
        $id = intval($id);
        switch ($action) {
            
            case 'pass':
                $status = RealnameAuthModel::realnameAuthPass($id);
                break;
            
            case 'deny':
                $status = RealnameAuthModel::realnameAuthDeny($id);
                break;
        }
        if ($status)
            return redirect('/manage/realnameAuthList')->with(array('message' => '操作成功'));
    }

    
    public function getBankAuth($id)
    {
        $id = intval($id);
        $info = BankAuthModel::where('id', $id)->first();

        if (!empty($info)){
            $data = array(
                'bank' => $info
            );
            return $this->theme->scope('manage.bankauthinfo', $data)->render();
        }
    }


    
    public function bankAuthPay(Request $request)
    {
        $authId = intval($request->get('authId'));
        $pay_to_user_cash = $request->get('pay_to_user_cash');

        $status = BankAuthModel::where('id', $authId)->update(array('pay_to_user_cash' => $pay_to_user_cash, 'status' => 1));
        if ($status)
            return redirect('manage/bankAuthList');
    }



    
    public function alipayAuthList(Request $request)
    {
        $merge = $request->all();
        $aliPayList = AlipayAuthModel::whereRaw('1=1');
        
        if ($request->get('alipayName')) {
            $aliPayList = $aliPayList->where('alipay_name','like','%'.$request->get('alipayName').'%');
        }
        
        if ($request->get('username')) {
            $aliPayList = $aliPayList->where('username','like','%'.$request->get('username').'%');
        }
        
        if ($request->get('alipay_account')) {
            $aliPayList = $aliPayList->where('alipay_account','like','%'.$request->get('alipay_account').'%');
        }
        
        if ($request->get('status')) {
            switch($request->get('status')){
                case 1:
                    $status = 0;
                    $aliPayList = $aliPayList->where('status',$status);
                    break;
                case 2:
                    $status = 1;
                    $aliPayList = $aliPayList->where('status',$status);
                    break;
                case 3:
                    $status = 2;
                    $aliPayList = $aliPayList->where('status',$status);
                    break;
                case 4:
                    $status = 3;
                    $aliPayList = $aliPayList->where('status',$status);
                    break;
            }
        }
        
        if($request->get('time_type')){
            $timeType = $request->get('time_type');
            if($request->get('start')){
                $start = date('Y-m-d H:i:s',strtotime($request->get('start')));
                $aliPayList = $aliPayList->where($timeType,'>',$start);

            }
            if($request->get('end')){
                $end = date('Y-m-d H:i:s',strtotime($request->get('end')));
                $aliPayList = $aliPayList->where($timeType,'<',$end);
            }

        }
        $by = $request->get('by') ? $request->get('by') : 'id';
        $order = $request->get('order') ? $request->get('order') : 'desc';
        $paginate = $request->get('paginate') ? $request->get('paginate') : 10;

        $aliPayList = $aliPayList->orderBy($by, $order)->paginate($paginate);

        $data = array(
            'merge' => $merge,
            'alipay' => $aliPayList,
        );

        $this->breadcrumb->add(array(
            array(
                'label' => '支付宝认证',
                'url' => '/manage/alipayAuthList'
            ),
            array(
                'label' => '认证列表'
            )
        ));
        $this->theme->set('manageAction', 'alipay');
        return $this->theme->scope('manage.alipaylist', $data)->render();
    }


    
    public function alipayAuthHandle($id, $action)
    {
        $id = intval($id);
        switch ($action) {
            
            case 'pass':
                $status = AlipayAuthModel::alipayAuthPass($id);
                break;
            
            case 'deny':
                $status = AlipayAuthModel::alipayAuthDeny($id);
                break;
        }
        if ($status)
            return redirect('/manage/alipayAuthList')->with(array('message' => '操作成功'));
    }


    
    public function getAlipayAuth($id)
    {
        $id = intval($id);
        $info = AlipayAuthModel::where('id', $id)->first();

        if (!empty($info)){
            $data = array(
                'alipay' => $info
            );
            return $this->theme->scope('manage.alipayauthinfo', $data)->render();
        }
    }

    
    public function alipayAuthPay(Request $request)
    {
        $authId = intval($request->get('authId'));
        $pay_to_user_cash = $request->get('pay_to_user_cash');

        $status = AlipayAuthModel::where('id', $authId)->update(array('pay_to_user_cash' => $pay_to_user_cash, 'status' => 1));
        if ($status)
            return redirect('manage/alipayAuthList');
    }

    
    public function bankAuthList(Request $request)
    {
        $merge = $request->all();
        $bankList = BankAuthModel::whereRaw('1 = 1');
        
        if ($request->get('bankAccount')) {
            $bankList = $bankList->where('bank_account','like','%'.$request->get('bankAccount').'%');
        }
        
        if ($request->get('username')) {
            $bankList = $bankList->where('username','like','%'.$request->get('username').'%');
        }
        
        if ($request->get('status')) {
            switch($request->get('status')){
                case 1:
                    $status = 0;
                    $bankList = $bankList->where('status',$status);
                    break;
                case 2:
                    $status = 1;
                    $bankList = $bankList->where('status',$status);
                    break;
                case 3:
                    $status = 2;
                    $bankList = $bankList->where('status',$status);
                    break;
                case 4:
                    $status = 3;
                    $bankList = $bankList->where('status',$status);
                    break;
            }
        }
        
        if($request->get('time_type')){
            $timeType = $request->get('time_type');
            if($request->get('start')){
                $start = date('Y-m-d H:i:s',strtotime($request->get('start')));
                $bankList = $bankList->where($timeType,'>',$start);

            }
            if($request->get('end')){
                $end = date('Y-m-d H:i:s',strtotime($request->get('end')));
                $bankList = $bankList->where($timeType,'<',$end);
            }

        }
        $by = $request->get('by') ? $request->get('by') : 'id';
        $order = $request->get('order') ? $request->get('order') : 'desc';
        $paginate = $request->get('paginate') ? $request->get('paginate') : 10;

        $bankList = $bankList->orderBy($by, $order)->paginate($paginate);

        $data = array(
            'merge' => $merge,
            'bank' => $bankList,
        );

        $this->breadcrumb->add(array(
            array(
                'label' => '银行认证',
                'url' => '/manage/bankAuthList'
            ),
            array(
                'label' => '认证列表'
            )
        ));
        $this->theme->set('manageAction', 'bank');
        return $this->theme->scope('manage.banklist', $data)->render();
    }


    
    public function bankAuthHandle($id, $action)
    {
        $id = intval($id);
        switch ($action) {
            
            case 'pass':
                $status = BankAuthModel::bankAuthPass($id);
                break;
            
            case 'deny':
                $status = BankAuthModel::bankAuthDeny($id);
                break;
        }
        if ($status)
            return redirect('/manage/bankAuthList')->with(array('message' => '操作成功'));
    }

    
    public function bankAuthMultiHandle(Request $request)
    {
        if (!$request->get('ckb')) {
            return \CommonClass::adminShowMessage('参数错误');
        }
        $objAuthRecord = new AuthRecordModel();
        $status = $objAuthRecord->multiHandle($request->get('ckb'), 'bank', 'pass');
        if ($status)
            return back();
    }

    
    public function enterpriseAuthList(Request $request)
    {
        $merge = $request->all();
        $enterpriseList = EnterpriseAuthModel::whereRaw('1 = 1');

        
        if ($request->get('name')) {
            $enterpriseList = $enterpriseList->where('users.name',$request->get('name'));
        }
        
        if ($request->get('company_name')) {
            $enterpriseList = $enterpriseList->where('enterprise_auth.company_name','like','%'.$request->get('company_name').'%');
        }
        
        if ($request->get('status')) {
            switch($request->get('status')){
                case 1:
                    $status = 1;
                    break;
                case 2:
                    $status = 2;
                    break;
                case 3:
                    $status = 0;
                    break;
                default:
                    $status = 0;
            }
            $enterpriseList = $enterpriseList->where('enterprise_auth.status',$status);
        }
        
        if($request->get('time_type')){
            if($request->get('start')){
                $start = date('Y-m-d H:i:s',strtotime($request->get('start')));
                $enterpriseList = $enterpriseList->where($request->get('time_type'),'>',$start);
            }
            if($request->get('end')){
                $end = date('Y-m-d H:i:s',strtotime($request->get('end')));
                $enterpriseList = $enterpriseList->where($request->get('time_type'),'<',$end);
            }

        }
        $by = $request->get('by') ? $request->get('by') : 'enterprise_auth.id';
        $order = $request->get('order') ? $request->get('order') : 'desc';
        $paginate = $request->get('paginate') ? $request->get('paginate') : 10;

        $enterpriseList = $enterpriseList->leftJoin('users','users.id','=','enterprise_auth.uid')
            ->select('enterprise_auth.*','users.name')
            ->orderBy($by, $order)->paginate($paginate);
        if($enterpriseList)
        {
            
            $cateId = array();
            foreach($enterpriseList as $k => $v){
                $cateId[] = $v['cate_id'];
            }
            $cate = TaskCateModel::whereIn('id',$cateId)->get();
            foreach($enterpriseList as $k => $v){
                foreach($cate as $key => $value){
                    if($v->cate_id == $value->id){
                        $enterpriseList[$k]['cate_name'] = $value->name;
                    }
                }
            }
        }
        $data = array(
            'merge' => $merge,
            'enterprise' => $enterpriseList,
        );

        $this->breadcrumb->add(array(
            array(
                'label' => '企业认证',
                'url' => '/manage/enterpriseAuthList'
            ),
            array(
                'label' => '认证列表'
            )
        ));
        $this->theme->set('manageAction', 'enterprise');
        return $this->theme->scope('manage.enterpriselist', $data)->render();
    }

    
    public function enterpriseAuthHandle($id, $action)
    {
        $id = intval($id);
        switch ($action) {
            
            case 'pass':
                $status = EnterpriseAuthModel::enterpriseAuthPass($id);
                break;
            
            case 'deny':
                $status = EnterpriseAuthModel::enterpriseAuthDeny($id);
                break;
        }
        if ($status){
            return redirect('/manage/enterpriseAuthList')->with(array('message' => '操作成功'));
        }
    }

    
    public function enterpriseAuth($id)
    {
        $id = intval($id);
        
        $preId = EnterpriseAuthModel::where('id','>',$id)->min('id');
        
        $nextId = EnterpriseAuthModel::where('id','<',$id)->max('id');
        
        $enterpriseInfo = EnterpriseAuthModel::getEnterpriseInfo($id);
        
        $enterpriseStatus = EnterpriseAuthModel::getEnterpriseAuthStatus($enterpriseInfo['uid']);
        if (!empty($enterpriseInfo)) {
            $data = array(
                'enterprise' => $enterpriseInfo,
                'enterprise_status' => $enterpriseStatus,
                'pre_id' => $preId,
                'next_id' => $nextId
            );
            return $this->theme->scope('manage.enterpriseauthinfo', $data)->render();
        }
    }

    
    public function allEnterprisePass(Request $request)
    {
        $ids = $request->get('ids');
        $idArr = explode(',',$ids);
        $res = EnterpriseAuthModel::AllEnterpriseAuthPass($idArr);
        if($res){
            $data = array(
                'code' => 1,
                'msg' => '操作成功'
            );
        }else{
            $data = array(
                'code' => 0,
                'msg' => '操作失败'
            );
        }
        return response()->json($data);
    }

    
    public function allEnterpriseDeny(Request $request)
    {
        $ids = $request->get('ids');
        $idArr = explode(',',$ids);
        $res = EnterpriseAuthModel::AllEnterpriseAuthDeny($idArr);
        if($res){
            $data = array(
                'code' => 1,
                'msg' => '操作成功'
            );
        }else{
            $data = array(
                'code' => 0,
                'msg' => '操作失败'
            );
        }
        return response()->json($data);
    }
}
