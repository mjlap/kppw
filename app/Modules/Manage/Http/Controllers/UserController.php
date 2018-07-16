<?php
namespace App\Modules\Manage\Http\Controllers;

use App\Http\Controllers\ManageController;
use App\Http\Requests;
use App\Modules\Manage\Model\ManagerModel;
use App\Modules\Manage\Model\MenuPermissionModel;
use App\Modules\Manage\Model\ModuleTypeModel;
use App\Modules\Manage\Model\Permission;
use App\Modules\Manage\Model\PermissionRoleModel;
use App\Modules\Manage\Model\Role;
use App\Modules\Manage\Model\RoleUserModel;
use App\Modules\User\Model\DistrictModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\User\Model\UserModel;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends ManageController
{
	
    public function __construct()
    {
        parent::__construct();
        $this->initTheme('manage');
        $this->theme->setTitle('用户管理');
        $this->theme->set('manageType', 'User');
    }

    
    public function getUserList(Request $request)
    {
        $list = UserModel::select('users.name', 'user_detail.created_at', 'user_detail.balance', 'users.id', 'users.last_login_time', 'users.status')
            ->leftJoin('user_detail', 'users.id', '=', 'user_detail.uid');

        if ($request->get('uid')){
            $list = $list->where('users.id', $request->get('uid'));
        }
        if ($request->get('username')){
            $list = $list->where('users.name','like', '%'.$request->get('username').'%');
        }
        if ($request->get('email')){
            $list = $list->where('users.email', $request->get('email'));
        }
        if ($request->get('mobile')){
            $list = $list->where('user_detail.mobile', $request->get('mobile'));
        }
        if (intval($request->get('status'))){
            switch(intval($request->get('status'))){
                case 1:
                    $status = 0;
                    break;
                case 2:
                    $status = 2;
                    break;
                case -1;
                    $status = [0,1,2];
                    break;
            }
            if(is_array($status)){
                $list = $list->whereIn('users.status', $status);
            }else{
                $list = $list->where('users.status', $status);
            }
        }
        $order = $request->get('order') ? $request->get('order') : 'desc';
        if ($request->get('by')){
            switch ($request->get('by')){
                case 'id':
                    $list = $list->orderBy('users.id', $order);
                    break;
                case 'created_at':
                    $list = $list->orderBy('users.created_at', $order);
                    break;
            }
        } else {
            $list = $list->orderBy('users.created_at', $order);
        }

        $paginate = $request->get('paginate') ? $request->get('paginate') : 10;
        
        $timeType = 'users.created_at';
        if($request->get('start')){
            $start = date('Y-m-d H:i:s',strtotime($request->get('start')));
            $list = $list->where($timeType,'>',$start);

        }
        if($request->get('end')){
            $end = date('Y-m-d H:i:s',strtotime($request->get('end')));
            $list = $list->where($timeType,'<',$end);
        }
        $list = $list->paginate($paginate);

        $data = [
            'status'=>$request->get('status'),
            'list' => $list,
            'paginate' => $paginate,
            'order' => $order,
            'by' => $request->get('by'),
            'uid' => $request->get('uid'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'mobile' => $request->get('mobile')
        ];
        $search = [
            'status'=>$request->get('status'),
            'paginate' => $paginate,
            'order' => $order,
            'by' => $request->get('by'),
            'uid' => $request->get('uid'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'mobile' => $request->get('mobile'),
            'start' => $request->get('start'),
            'end' => $request->get('end')
        ];
        $data['search'] = $search;
        $this->theme->setTitle('普通用户');
 		return $this->theme->scope('manage.userList', $data)->render();
    }

    
    public function handleUser($uid, $action)
    {
        switch ($action){
            case 'enable':
                $status = 1;
                break;
            case 'disable':
                $status = 2;
                break;
        }
        $status = UserModel::where('id', $uid)->update(['status' => $status]);
        if ($status)
            return back()->with(['message' => '操作成功']);
    }

    
    public function getUserAdd()
    {
        $province = DistrictModel::findTree(0);
        $data = [
            'province' => $province
        ];
 		return $this->theme->scope('manage.userAdd', $data)->render();
    }

    
    public function postUserAdd(Request $request)
    {
        
        $salt = \CommonClass::random(4);
        $data = [
            'name' => $request->get('name'),
            'realname' => $request->get('realname'),
            'mobile' => $request->get('mobile'),
            'qq' => $request->get('qq'),
            'email' => $request->get('email'),
            'province' => $request->get('province'),
            'city' => $request->get('city'),
            'area' => $request->get('area'),
            'password' => UserModel::encryptPassword($request->get('password'), $salt),
            'salt' => $salt
        ];
        $status = UserModel::addUser($data);
        if ($status)
            return redirect('manage/userList')->with(['message' => '操作成功']);
    }

    
    public function checkUserName(Request $request){
        $username = $request->get('param');
        $status = UserModel::where('name', $username)->first();
        if (empty($status)){
            $status = 'y';
            $info = '';
        } else {
            $info = '用户名不可用';
            $status = 'n';
        }
        $data = array(
            'info' => $info,
            'status' => $status
        );
        return json_encode($data);
    }

    
    public function checkEmail(Request $request){
        $email = $request->get('param');

        $status = UserModel::where('email', $email)->first();
        if (empty($status)){
            $status = 'y';
            $info = '';
        } else {
            $info = '邮箱已占用';
            $status = 'n';
        }
        $data = array(
            'info' => $info,
            'status' => $status
        );
        return json_encode($data);
    }

    
    public function getUserEdit($uid)
    {
        $info = UserModel::select('users.name', 'user_detail.realname', 'user_detail.mobile', 'user_detail.qq', 'users.email', 'user_detail.province'
            , 'user_detail.city', 'user_detail.area', 'users.id')
            ->where('users.id', $uid)
            ->leftJoin('user_detail', 'users.id', '=', 'user_detail.uid')->first()->toArray();

        $province = DistrictModel::findTree(0);
        $data = [
            'info' => $info,
            'province' => $province,
            'city' => DistrictModel::getDistrictName($info['city']),
            'area' => DistrictModel::getDistrictName($info['area'])
        ];
 		return $this->theme->scope('manage.userDetail', $data)->render();
    }

    
    public function postUserEdit(Request $request)
    {
        
        if(!empty($request->get('mobile'))){
            $isExistsUser = UserModel::where('id','!=',$request->get('uid'))->where('mobile',$request->get('mobile'))->exists();
            $isExistsDetail = UserDetailModel::where('uid','!=',$request->get('uid'))->where('mobile',$request->get('mobile'))->exists();
            if($isExistsUser || $isExistsDetail){
                return redirect('/manage/userEdit/'.$request->get('uid'))->with(['message' => '手机号已经被占用']);
            }
        }
        
        $user = UserModel::find($request->get('uid'));
        if(empty($request->get('password'))){
            $password = $user->password;
        }else{
            $password = UserModel::encryptPassword($request->get('password'), $user->salt);
        }
        $data = [
            'uid' => $request->get('uid'),
            'realname' => $request->get('realname'),
            'mobile' => $request->get('mobile'),
            'qq' => $request->get('qq'),
            'email' => $request->get('email'),
            'province' => $request->get('province'),
            'city' => $request->get('city'),
            'area' => $request->get('area'),
            'password' => $password,
        ];
        $status = UserModel::editUser($data);
        if ($status)
            return redirect('manage/userList')->with(['message' => '操作成功']);

    }

    
   	public function getManagerList(Request $request)
   	{
        $merge = $request->all();
        $list = ManagerModel::select('manager.id','manager.username','roles.display_name','manager.status','manager.email','manager.telephone','manager.QQ')->leftJoin('role_user','manager.id','=','role_user.user_id')
           ->leftJoin('roles','roles.id','=','role_user.role_id');
        $roles = Role::get();
        if($request->get('uid')){
            $list = $list->where('manager.id',$request->get('uid'));
        }
        if($request->get('username')){

            $list = $list->where('manager.username','like','%'. $request->get('username').'%');
        }
        if($request->get('QQ')){

            $list = $list->where('manager.QQ','like','%'. $request->get('QQ').'%');
        }
        if($request->get('email')){

            $list = $list->where('manager.email','like','%'. $request->get('email').'%');
        }
        if($request->get('display_name') && $request->get('display_name') != '全部'){
            $list = $list->where('roles.id',$request->get('display_name'));
        }
        if($request->get('telephone')){

            $list = $list->where('manager.telephone','like','%'. $request->get('telephone').'%');
        }
        if ($request->get('status')!=""){
            $list = $list->where('manager.status', $request->get('status'));
        }
        if($request->get('role_id')!=""){
            $list = $list->where('roles.id', $request->get('role_id'));
        }

        $order = $request->get('order') ? $request->get('order') : 'desc';
        $paginate = $request->get('paginate') ? $request->get('paginate') : 10;
        $list = $list->orderBy('manager.id',$order)->paginate($paginate);
        $listArr = $list->toArray();
        $data = array(
            'merge' => $merge,
            'listArr' => $listArr,
            'status'=>$request->get('status'),
            'by' => $request->get('by'),
            'order' => $order,
            'display_name'=>$request->get('display_name'),
            'uid'=>$request->get('uid'),
            'username'=>$request->get('username'),
            'QQ'=>$request->get('QQ'),
            'email'=>$request->get('email'),
            'telephone'=>$request->get('telephone'),
            'list'=>$list,
            'roles'=>$roles,
            'role_id'=>$request->get('role_id'),
       );
        $this->theme->setTitle('系统用户');
		return $this->theme->scope('manage.managerList',$data)->render();
   	}

    
    public function handleManage($uid, $action)
    {
        switch ($action){
            case 'enable':
                $status = 1;
                break;
            case 'disable':
                $status = 2;
                break;
        }
        $status = ManagerModel::where('id', $uid)->update(['status' => $status]);
        if ($status)
            return back()->with(['message' => '操作成功']);
    }

    
    public function checkManageName(Request $request){
        $username = $request->get('param');
        $status = ManagerModel::where('username', $username)->first();
        if (empty($status)){
            $status = 'y';
            $info = '';
        } else {
            $info = '用户名不可用';
            $status = 'n';
        }
        $data = array(
            'info' => $info,
            'status' => $status
        );
        return json_encode($data);
    }

    
    public function checkManageEmail(Request $request){
        $email = $request->get('param');

        $status = ManagerModel::where('email', $email)->first();
        if (empty($status)){
            $status = 'y';
            $info = '';
        } else {
            $info = '邮箱已占用';
            $status = 'n';
        }
        $data = array(
            'info' => $info,
            'status' => $status
        );
        return json_encode($data);
    }

    
    public function postManagerDeleteAll(Request $request){
       
        $data = $request->except('_token');
        
        if(!$data['chk']){
            return  redirect('manage/managerList')->with(array('message' => '操作失败'));
        }
        $status = DB::transaction(function () use ($data) {
            foreach ($data['chk'] as $id) {
                ManagerModel::where('id', $id)->delete();
               RoleUserModel::where('user_id', $id)->delete();
            }
        });
        if(is_null($status))
        {
            return redirect()->to('manage/managerList')->with(array('message' => '操作成功'));
        }
        return  redirect()->to('manage/managerList')->with(array('message' => '操作失败'));
    }

    
    public function managerDel($id){
        $status = DB::transaction(function () use ($id){
            ManagerModel::where('id',$id)->delete();
            RoleUserModel::where('user_id',$id)->delete();
        });

        if (is_null($status))
            return redirect()->to('manage/managerList')->with(['message' => '操作成功']);
    }
    
   	public function managerAdd()
   	{
        $roles = Role::get();
        $data = array(
            'roles'=>$roles
        );
		return $this->theme->scope('manage.managerAdd',$data)->render();
   	}

    
    public function postManagerAdd(Request $request)
    {
        $status = DB::transaction(function () use ($request) {
            $salt = \CommonClass::random(4);
            $data = [
                'username' => $request->get('username'),
                'realname' => $request->get('realname'),
                'telephone' => $request->get('telephone'),
                'QQ' => $request->get('QQ'),
                'email' => $request->get('email'),
                'password' => ManagerModel::encryptPassword($request->get('password'), $salt),
                'birth' => $request->get('birth'),
                'salt' => $salt,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time())
            ];
            ManagerModel::insert($data);
            $user = ManagerModel::where('username',$request->get('username'))->first();
            if($request->get('role_id'))
              $user->attachRole($request->get('role_id'));
        });
        if (is_null($status))
            return redirect('manage/managerList')->with(['message' => '操作成功']);
    }

    
   	public function managerDetail($id)
   	{
        $info = ManagerModel::select('manager.id','manager.username','manager.status','manager.email','manager.telephone','manager.QQ','manager.password','role_user.role_id')->leftJoin('role_user','manager.id','=','role_user.user_id')
            ->leftJoin('roles','roles.id','=','role_user.role_id')->where('manager.id',$id)->first();
        $roles = Role::get();
        $data = array(
            'roles'=>$roles,
            'info'=>$info,

        );
		return $this->theme->scope('manage.managerDetail',$data)->render();
   	}

    
    public function postManagerDetail(Request $request)
    {
        $status = DB::transaction(function () use ($request) {
            $id = $request->get('uid');
            if(!ManagerModel::where('id',$id)->where('password',$request->get('password'))->first()) {
                $salt = \CommonClass::random(4);
                $data = array(
                    'realname' => $request->get('realname'),
                    'telephone' => $request->get('telephone'),
                    'QQ' => $request->get('QQ'),
                    'password' => ManagerModel::encryptPassword($request->get('password'), $salt),
                    'birth' => $request->get('birth'),
                    'salt' => $salt,
                    'updated_at' => date('Y-m-d H:i:s', time())
                );
            }else{
                $data = array(
                    'realname' => $request->get('realname'),
                    'telephone' => $request->get('telephone'),
                    'QQ' => $request->get('QQ'),
                    'birth' => $request->get('birth'),
                    'updated_at' => date('Y-m-d H:i:s', time())
                );
            }
            ManagerModel::where('id', $id)->update($data);
            $user = ManagerModel::where('id',$id)->first();
            RoleUserModel::where('user_id',$id)->delete();
            $user->attachRole($request->get('role_id'));



        });
       if (is_null($status))
            return redirect('manage/managerList')->with(['message' => '操作成功']);
    }


    
    public function getRolesList()
    {
        $list =  Role::select('roles.id','roles.display_name','roles.updated_at')->orderBy('roles.id','DESC')->paginate(10);
        $data = array(
            'list'=>$list
        );
        $this->theme->setTitle('角色管理');
        return $this->theme->scope('manage.rolesList',$data)->render();
    }

    
    public function getRolesAdd()
    {
        $tree_menu = Permission::getPermissionMenu();
        $data = array(
            'list' =>$tree_menu,
        );
        return $this->theme->scope('manage.rolesAdd',$data)->render();
    }
    
    public function postRolesAdd(Request $request)
    {
          if(!count($request->get('id'))){
            return redirect('manage/rolesAdd')->with(['message' => '请设置用户组权限']);
        }
        $status = DB::transaction(function () use ($request) {
            $data = array(
                'name' => $request->get('name'),
                'display_name'=>$request->get('display_name'),
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time())
            );
            $role_id = Role::insertGetId($data);
            foreach ($request->get('id') as $id) {
                $role_id = $role_id;
                $data2 = array(
                    'permission_id' => $id,
                    'role_id' => $role_id
                );
                $re2 = PermissionRoleModel::insert($data2);
            }
        });
        if (is_null($status))
            return redirect('manage/rolesList')->with(['message' => '操作成功']);
    }

    
    public function getRolesDel($id)
    {
        $status = DB::transaction(function () use ($id) {
            Role::where('id', $id)->delete();
            PermissionRoleModel::where('role_id',$id)->delete();
        });
        if (is_null($status))
            return redirect()->to('manage/rolesList')->with(['message' => '操作成功']);
    }

    
    public function getRolesDetail($id)
    {
        $tree_menu = Permission::getPermissionMenu();

        $info1 = Role::where('id',$id)->first();
        $info = Role::select('roles.name','permissions.id','permissions.display_name')->join('permission_role','roles.id','=','permission_role.role_id')
            ->join('permissions','permissions.id','=','permission_role.permission_id')->where('roles.id',$id)->get();
        $ids = array();
        foreach ($info as $v) {
            $ids[] .= $v['id'];
        }
        $data = array(
            'ids'=>$ids,
            'info1'=>$info1,
            'info'=>$info,
            'list'=>$tree_menu,
        );
        return $this->theme->scope('manage.rolesDetail',$data)->render();
    }

    
    public function postRolesDetail(Request $request)
    {
        $status = DB::transaction(function () use ($request) {
            $rid = $request->get('rid');
            $data = array(
                'name' => $request->get('name'),
                'display_name'=>$request->get('display_name'),
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time())
            );
            Role::where('id', $rid)->update($data);

            PermissionRoleModel::where('role_id', $rid)->delete();

            if($request->get('id')) {
                foreach ($request->get('id') as $id) {
                    $role_id = $rid;
                    $data2 = array(
                        'permission_id' => $id,
                        'role_id' => $role_id
                    );
                    PermissionRoleModel::insert($data2);
                }
            }
        });
        if (is_null($status))
            return redirect('manage/rolesList')->with(['message' => '操作成功']);
    }

    
    public function getPermissionsList(Request $request)
    {
        $merge = $request->all();
        $list = Permission::select('permissions.id','permissions.name','permissions.display_name','permissions.module_type','menu.name as menu_name')
            ->leftJoin('menu','menu.id','=','permissions.module_type');
        if ($request->get('id')){
            $list = $list->where('permissions.id', $request->get('id'));
        }
        if ($request->get('display_name')){
            $list = $list->where('permissions.display_name','like','%'. $request->get('display_name').'%');
        }
        if ($request->get('name')){
            $list = $list->where('permissions.name','like','%'.  $request->get('name').'%');
        }
        $order = $request->get('order') ? $request->get('order') : 'desc';
        if ($request->get('module_type')!=""){
            $list = $list->where('permissions.module_type', $request->get('module_type'));
        }
        $paginate = $request->get('paginate') ? $request->get('paginate') : 10;
        $list = $list->orderBy('permissions.id',$order)->paginate($paginate);
        $listArr = $list->toArray();
        $type = ModuleTypeModel::get();
        $data = array(
            'merge' => $merge,
            'listArr' => $listArr,
            'id'=>$request->get('id'),
            'display_name'=>$request->get('display_name'),
            'name'=>$request->get('name'),
            'module_type'=>$request->get('module_type'),
            'type'=>$type,
            'list'=>$list,
            'paginate' => $paginate,
        );
        $this->theme->setTitle('权限设置');
        return $this->theme->scope('manage.permissionsList',$data)->render();
    }

    
    public function getPermissionsAdd()
    {
        $modules = ModuleTypeModel::get();
        $data = array(
            'modules'=>$modules
        );
        return $this->theme->scope('manage.permissionsAdd',$data)->render();
    }

    
    public function postPermissionsAdd(Request $request)
    {
        $data = $request->except('_token');
        $status = DB::transaction(function() use($data){
            $re =  Permission::insertGetId($data);
            
            $permission_user = ['menu_id'=>$data['module_type'],'permission_id'=>$re];
            MenuPermissionModel::insert($permission_user);
        });

        if(is_null($status))
            return redirect('manage/permissionsList')->with(['message' => '操作成功']);
    }

    
    public function getPermissionsDel($id){
        $re = Permission::where('id',$id)->delete();
        if($re)
            return redirect()->to('manage/permissionsList')->with(['message' => '操作成功']);
    }

    
    public function getPermissionsDetail($id)
    {
        
        $preId = Permission::where('id', '>', $id)->min('id');
        
        $nextId = Permission::where('id', '<', $id)->max('id');
        $info = Permission::select('permissions.*','mp.menu_id')
            ->where('permissions.id',$id)
            ->join('menu_permission as mp','permissions.id','=','mp.permission_id')
            ->first();
        $modules = ModuleTypeModel::get();
        $data = array(
            'modules'=>$modules,
            'info'=>$info,
            'preId'=>$preId,
            'nextId'=>$nextId
        );
        return $this->theme->scope('manage.permissionsDetail',$data)->render();
    }

    
    public function postPermissionsDetail(Request $request)
    {
        $id = $request->get('id');
        $menu_id = $request->get('menu_id');
        $data = $request->except('id','_token','menu_id');
        $re = Permission::where('id',$id)->update($data);
        $permission = Permission::where('id',$id)->first();
        
        $result1 = MenuPermissionModel::where('permission_id',$permission['id'])->delete();
        $result = MenuPermissionModel::firstOrCreate(['menu_id'=>$menu_id,'permission_id'=>$permission['id']]);
        if($re || $result)
            return redirect('manage/permissionsList')->with(['message' => '操作成功']);

    }
}
