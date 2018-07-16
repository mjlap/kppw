<?php

namespace App\Http\Controllers;

use App\Modules\Manage\Model\ConfigModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Route;
use Theme;
use App\Modules\Task\Model\TaskCateModel;
use Cache;

class BasicController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    
    public $theme;
    public $themeName;
    
    public $breadcrumb;


    public function __construct()
    {
        $this->checkInstall();
        
        $this->themeName = \CommonClass::getConfig('theme');
        

        $this->theme = $this->initTheme();
        
        $skin_color_config = \CommonClass::getConfig('skin_color_config');
        if($skin_color_config)
        {
            $this->theme->set('color', $skin_color_config);
        }
        
        $siteConfig = ConfigModel::getConfigByType('site');
        $this->theme->set('site_config',$siteConfig);

    }

    
    public function initTheme($layout = 'default')
    {
        return Theme::uses($this->themeName)->layout($layout);
    }

    
    public function manageBreadcrumb()
    {
        return $this->theme->breadcrumb()->setTemplate('
            <ul class="breadcrumb">
            @foreach ($crumbs as $i => $crumb)
                @if ($i != (count($crumbs) - 1))
                <li>
                <i class="ace-icon fa fa-tasks home-icon"></i>
                <a href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a>
                </li>
                @else
                <li class="active">{{ $crumb["label"] }}</li>
                @endif
            @endforeach
            </ul>
        ');
    }

    public function checkInstall()
    {
        if (!file_exists(base_path('kppw.install.lck'))){
            header('Location:' . \CommonClass::getDomain() . '/install');
            die('未检测到安装文件');
        }
    }
}
