<?php
namespace App\Modules\Manage\Http\Controllers;

use App\Http\Controllers\ManageController;
use App\Http\Requests;
use App\Modules\User\Model\PromoteModel;
use App\Modules\User\Model\PromoteTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoteController extends ManageController
{
    public function __construct()
    {
        parent::__construct();
        $this->initTheme('manage');

    }

    
    public function promoteRelation(Request $request)
    {
        $merge = $request->all();
        $list = PromoteModel::whereRaw('1=1');
        
        if($request->get('from_name')){
            $list = $list->where('from.name','like','%'.$request->get('from_name').'%');
        }
        
        if($request->get('to_name')){
            $list = $list->where('to.name','like','%'.$request->get('to_name').'%');
        }
        
        if($request->get('start')){
            $start = date('Y-m-d H:i:s',strtotime($request->get('start')));
            $list = $list->where('promote.created_at', '>',$start);
        }
        if($request->get('end')){
            $end = date('Y-m-d H:i:s',strtotime($request->get('end')));
            $list = $list->where('promote.created_at', '<',$end);
        }
        $list = $list->leftJoin('users as from','from.id','=','promote.from_uid')
            ->leftJoin('users as to','to.id','=','promote.to_uid')
            ->select('promote.*','from.name as from_name','to.name as to_name')
            ->orderBy('promote.created_at','DESC')->paginate(10);
        $data = array(
            'merge' => $merge,
            'list' => $list
        );
        $this->theme->setTitle('推广关系');
        return $this->theme->scope('manage.entendrelation',$data)->render();
    }

    
    public function promoteFinance(Request $request)
    {
        $list = PromoteModel::where('promote.status',2);
        $merge = $request->all();
        
        if($request->get('from_name')){
            $list = $list->where('from.name','like','%'.$request->get('from_name').'%');
        }
        
        if($request->get('to_name')){
            $list = $list->where('to.name','like','%'.$request->get('to_name').'%');
        }
        
        if($request->get('start')){
            $start = date('Y-m-d H:i:s',strtotime($request->get('start')));
            $list = $list->where('promote.created_at', '>',$start);
        }
        if($request->get('end')){
            $end = date('Y-m-d H:i:s',strtotime($request->get('end')));
            $list = $list->where('promote.created_at', '<',$end);
        }
        $list = $list->leftJoin('users as from','from.id','=','promote.from_uid')
            ->leftJoin('users as to','to.id','=','promote.to_uid')
            ->select('promote.*','from.name as from_name','to.name as to_name')
            ->orderBy('promote.created_at','DESC')->paginate(10);
        $data = array(
            'merge' => $merge,
            'list' => $list
        );
        $this->theme->setTitle('推广财务');

        return $this->theme->scope('manage.entendfinance',$data)->render();
    }


    
    public function promoteConfig()
    {
        
        $promoteType = PromoteTypeModel::where('code_name','ZHUCETUIGUANG')->first();
        $data = array(
            'promote_type' => $promoteType
        );
        $this->theme->setTitle('推广配置');
        return $this->theme->scope('manage.entendConfig',$data)->render();
    }

    
    public function postPromoteConfig(Request $request)
    {
        $data = $request->except('_token');
        $arr = array(
            'is_open' => $data['is_open'],
            'finish_conditions' => $data['finish_conditions'],
            'price' => $data['price']
        );
        $res = PromoteTypeModel::where('code_name','ZHUCETUIGUANG')->update($arr);
        if($res){
            return redirect('/manage/promoteConfig')->with(array('message' => '操作成功'));
        }else{
            return redirect('/manage/promoteConfig')->with(array('message' => '操作失败'));
        }
    }








}

