<?php

namespace App\Http\Controllers;

use App\Modules\Manage\Model\MenuModel;
use App\Modules\Manage\Model\MenuPermissionModel;
use App\Modules\Manage\Model\Permission;
use App\Modules\Manage\Model\ManagerModel;
use App\Modules\Manage\Model\ConfigModel;
use Illuminate\Support\Facades\Route;
use Cache;


class ManageController extends BasicController
{
    public $manager;
    public function __construct()
    {
        parent::__construct();
        
        $this->themeName = 'admin';
        
        if (ManagerModel::getManager())
        {
            
            $this->manageBreadcrumb();
            $this->breadcrumb = $this->theme->breadcrumb();
            $this->manager = ManagerModel::getManager();
            $this->theme->setManager($this->manager->username);

            
            $manageMenu = MenuModel::getMenuPermission();
            $this->theme->set('manageMenu', $manageMenu);
        }

        
        $route = Route::currentRouteName();
        
        if($route!='loginCreatePage')
        {
            $permission = Permission::where('name',$route)->first();
            if(!is_null($permission))
            {
                $permission = MenuPermissionModel::where('permission_id',$permission['id'])->first();
                
                $menu_data = MenuModel::getMenu($permission['menu_id']);
                $this->theme->set('menu_data', $menu_data['menu_data']);
                $this->theme->set('menu_ids',$menu_data['menu_ids']);
            }
        }

        
        $basisConfig = ConfigModel::getConfigByType('basis');
        if(!empty($basisConfig)){
            $this->theme->set('basis_config',$basisConfig);
        }

        
        if (isset($_SERVER['Authentication']) && 172 == strlen($_SERVER['Authentication'])){
            $isCertificate = 1;
        }else{
            $isCertificate = 0;
        }
        $this->theme->set('is_certificate',$isCertificate);

        
        $menuIcon = [
            '首页'=>'fa-home',
            '全局'=>'fa-cog',
            '用户'=>'fa-users',
            '店铺'=>'fa-home',
            '任务'=>'fa-tasks',
            '工具'=>'fa-user',
            '资讯'=>'fa-file-text',
            '财务'=>'fa-bar-chart-o',
            '消息'=>'fa-envelope',
            '应用'=>'fa fa-pencil-square-o'
        ];
        $this->theme->set('menuIcon',$menuIcon);

        
        $kppwAuthCode = config('kppw.kppw_auth_code');
        if(!empty($kppwAuthCode)){
            $kppwAuthCode = \CommonClass::starReplace($kppwAuthCode, 5, 4);
            $this->theme->set('kppw_auth_code',$kppwAuthCode);
        }

    }
}
