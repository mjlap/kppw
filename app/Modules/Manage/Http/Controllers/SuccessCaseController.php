<?php
namespace App\Modules\Manage\Http\Controllers;

use App\Http\Controllers\BasicController;
use App\Http\Controllers\ManageController;
use App\Modules\Manage\Model\ConfigModel;
use App\Modules\Manage\Model\NavigationModel;
use App\Modules\Manage\Model\IndustryModel;
use App\Modules\Manage\Model\ServiceObjectModel;
use App\Modules\Manage\Model\StyleModel;
use App\Modules\Task\Model\SuccessCaseModel;
use App\Modules\Task\Model\TaskCateModel;
use App\Modules\User\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Theme;


class SuccessCaseController extends ManageController
{
    public $user;
    public function __construct()
    {
        parent::__construct();
        $this->user = $this->manager;
        $this->initTheme('manage');
        $this->theme->setTitle('成功案例管理');
        $this->theme->set('manageType', 'successCase');
    }

    
    public function successCaseList(Request $request)
    {
        $data = $request->all();

        $query = SuccessCaseModel::select('success_case.*');
        
        if($request->get('commentname'))
        {
            $query = $query->where('success_case.username','like',"%".e($request->get('commentname'))."%");
        }
        
        if($request->get('title'))
        {
            $query = $query->where('success_case.title','like',"%".e($request->get('title')).'%');
        }
        
        if($request->get('from') && $request->get('from')!=0)
        {
            if($request->get('from')==1)
            {
                $query = $query->where('success_case.type','=',0);
            }else{
                $query = $query->where('success_case.type','=',1);
            }
        }
        
        $orderBy = 'id';
        if($request->get('orderBy'))
        {
            $orderBy = $request->get('orderBy');
        }
        $orderByType = 'acs';
        if($request->get('orderByType'))
        {
            $orderByType = $request->get('orderByType');
        }
        
        $page_size = 10;
        if($request->get('pageSize'))
        {
            $page_size = $request->get('pageSize');
        }
        if($request->get('start')){
            $start = date('Y-m-d H:i:s',strtotime($request->get('start')));
            $query = $query->where('success_case.created_at','>',$start);
        }
        if($request->get('end')){
            $end = date('Y-m-d H:i:s',strtotime($request->get('end')));
            $query = $query->where('success_case.created_at','<',$end);
        }
        $comments_page = $query
            ->orderBy($orderBy,$orderByType)
            ->paginate($page_size);
        $comments = $comments_page->toArray();
        if($comments['total'] > 0){
            foreach($comments['data'] as $k => $v){
                if(!empty($v['cate_id'])){
                    $cate = TaskCateModel::findById($v['cate_id']);

                    if(!empty($cate)){
                        $comments['data'][$k]['cate_name'] = $cate['name'];
                    }else{
                        $comments['data'][$k]['cate_name'] = '';
                    }
                }else{
                    $comments['data'][$k]['cate_name'] = '';
                }
            }
        }
        $view = [
            'data'=>$comments,
            'merge'=>$data,
            'comments_page'=>$comments_page
        ];
        $this->theme->setTitle('案例管理');
        return $this->theme->scope('manage.successCaseList',$view)->render();
    }

    
    public function create(Request $request)
    {
        $data = $request->all();

        
        $cateFirst = TaskCateModel::findByPid([0],['id','name']);
        if(isset($data['id']))
        {
            $successCase = SuccessCaseModel::getSuccessInfoById($data['id']);

            
            $cateSecond = TaskCateModel::findByPid([$successCase->cate_pid]);
            $view = array(
                'cate_first' => $cateFirst,
                'cate_second' => $cateSecond,
                'success_case' => $successCase
            );
        }else{
            if(!empty($cateFirst)){
                
                $cateSecond = TaskCateModel::findByPid([$cateFirst[0]['id']],['id','name']);
            }else{
                $cateSecond = array();
            }
            $view = [
                'cate_first' => $cateFirst,
                'cate_second' => $cateSecond
            ];
        }
        $request->get('id')?$this->theme->setTitle('案例编辑'):$this->theme->setTitle('案例添加');
        return $this->theme->scope('manage.successcaseadd', $view)->render();
    }

    
    public function update(Request $request)
    {
        $data = $request->except('_token');
        $file = $request->file('pic');
        
        if(isset($data['id']))
        {
            $success_case = [
                'uid'=>$this->user['id'],
                'username'=>$this->user['username'],
                'desc' => $data['desc'],

                'url'=>$data['url'],
                'title'=>$data['title'],
            ];
            
            if(!empty($file))
            {
                $result = \FileClass::uploadFile($file,'sys');
                $result = json_decode($result,true);
                $success_case = array_add($success_case,'pic',$result['data']['url']);
            }
            
            if(!empty($data['cate_id']))
            {
                $success_case = array_add($success_case,'cate_id',$data['cate_id']);
            }

            $result2 = SuccessCaseModel::where('id',$data['id'])->update($success_case);

            if(!$result2)
                return redirect()->back()->with('error','成功案例修改失败！');
        }else{
            $result = \FileClass::uploadFile($file,'sys');

            $result = json_decode($result,true);
            $success_case = [
                'uid'=>$this->user['id'],
                'desc' => $data['desc'],

                'url'=>$data['url'],
                'title'=>$data['title'],
                'pic'=>$result['data']['url'],
                'cate_id'=>$data['cate_id'],
                'type'=>0,
                'view_count'=>0,
                'created_at'=>date('Y-m-d H:i:s',time()),
            ];
            $result3 = SuccessCaseModel::create($success_case);

            if(!$result3)
                return redirect()->back()->with('error','成功案例添加失败！');
        }

        return redirect()->to('manage/successCaseList')->with('massage','操作成功！');
    }

    
    public function successCaseDel($id)
    {
        $attachment = SuccessCaseModel::where('id', $id)->first();
        if (!empty($attachment)){
            $status = $attachment->delete();
            if ($status){
                return redirect()->back()->with(['message' => '操作成功']);
            }
        }
        return redirect()->back()->with(['error' => '删除失败']);
    }

    
    public function ajaxGetSecondCate(Request $request)
    {
        $id = intval($request->get('id'));
        if (!$id) {
            return response()->json(['errMsg' => '参数错误！']);
        }
        $cate = TaskCateModel::findByPid([$id]);
        $data = [
            'cate' => $cate
        ];
        return response()->json($data);
    }

}