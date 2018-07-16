<?php
namespace App\Modules\Manage\Http\Controllers;

use App\Http\Controllers\ManageController;
use App\Http\Requests;
use App\Modules\Task\Model\TaskCateModel;
use App\Modules\Task\Model\TaskTemplateModel;
use App\Modules\User\Model\TagsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndustryController extends ManageController
{
    public function __construct()
    {
        parent::__construct();

        $this->initTheme('manage');
        $this->theme->setTitle('行业管理');
        $this->theme->set('manageType', 'industry');
    }
    
    public function industryList()
    {
        $category_data = TaskCateModel::findByPid([0]);
        $data = [
            'category_data'=>$category_data,
        ];

        return $this->theme->scope('manage.industrylist', $data)->render();
    }

    
    public function industryDelete($id)
    {
        $result = TaskCateModel::destroy($id);
        if(!$result)
        {
            return response()->json(['errCode'=>0,'errMsg'=>'删除失败！']);
        }
        Cache::forget('task_cate');
        return response()->json(['errCode'=>1,'id'=>$id]);
    }

    
    public function industryCreate(Request $request)
    {
        $data = $request->except('_token');
        
        
        if(!empty($data['second']) && $data['third']==$data['second'])
        {
            $pid = $data['second'];
            $path = '-0-'.$pid.'-';
        }elseif(!empty($data['third']) && $data['third']!=$data['second'])
        {
            $pid = $data['third'];
            $path = '-0-'.$data['second'].'-'.$data['third'].'-';
        }else
        {
            $pid = 0;
            $path = '-0-';
        }
        
        foreach($data['name'] as $k=>$v)
        {
            $change_ids = explode(' ',$data['change_ids']);
            if(in_array($k,$change_ids)){
                $result = TaskCateModel::where('pid',$pid)->where('id',$k)->update(['name'=>$v,'sort'=>$data['sort'][$k]]);
                
                if(!empty($data['third']) && $result)
                {
                    TagsModel::where('cate_id',$k)->update(['tag_name'=>$v]);
                    
                    TagsModel::betteringCache();
                }
                if(!$result)
                {
                    $task_cate = TaskCateModel::firstOrCreate(['name'=>$v,'pid'=>$pid,'path'=>$path,'sort'=>$data['sort'][$k]]);
                    if(!empty($data['third']) && $task_cate)
                    {
                        $tags = TagsModel::firstOrCreate(['tag_name' => $task_cate['name']]);
                        TagsModel::where('id',$tags['id'])->update(['cate_id'=>$task_cate['id']]);
                        
                        TagsModel::betteringCache();
                    }
                }
            }
        }
        Cache::forget('task_cate');
        return redirect()->back()->with(['massage'=>'修改成功！']);
    }

    
    public function ajaxSecond(Request $request)
    {
        $id = intval($request->get('id'));
        if(is_null($id)){
            return response()->json(['errMsg'=>'参数错误！']);
        }
        $province = TaskCateModel::findByPid([$id]);
        $domain = \CommonClass::getDomain();
        if(!empty($province)){
            foreach($province as $k => $v){
                $province[$k]['pic'] = $domain.'/'.$v['pic'];
            }
        }

        $data = [
            'province'=>$province,
            'id'=>$id
        ];
        return response()->json($data);
    }

    
    public function ajaxThird(Request $request)
    {
        $id = intval($request->get('id'));
        if(is_null($id)){
            return response()->json(['errMsg'=>'参数错误！']);
        }
        $area = TaskCateModel::findByPid([$id]);
        $domain = \CommonClass::getDomain();
        if(!empty($area)){
            foreach($area as $k => $v){
                $area[$k]['pic'] = $domain.'/'.$v['pic'];
            }
        }
        return response()->json($area);
    }

    
    public function taskTemplates($id)
    {
        
        $industry = TaskCateModel::findById($id);
        
        if($industry['pid']!=0)
        {
            return redirect()->back()->with(['error'=>'只有一级分类才能添加实例！']);
        }

        
        $task_template = TaskTemplateModel::where('cate_id',$id)->first();

        $data = [
            'template'=>$task_template,
            'industry'=>$industry,
        ];

        return $this->theme->scope('manage.tasktemplate', $data)->render();
    }

    
    public function templateCreate(Request $request)
    {
        $data = $request->except('_token');
        $data['content'] = e($data['desc']);
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s',time());

        $template = TaskTemplateModel::where('cate_id',$data['cate_id'])->first();

        if($template)
        {
            $result = TaskTemplateModel::where('id',$template['id'])->update(['title'=>$data['title'],'content'=>$data['content']]);
        }else{
           $result =  TaskTemplateModel::create($data);
        }

        if(!$result)
            return redirect()->back()->with(['error'=>'操作失败！']);

        return redirect()->back()->with(['message'=>'操作成功']);
    }


    
    public function industryInfo($id)
    {
        $cate = TaskCateModel::findById($id);
        if(!empty($cate)){
            
            $parentCate = TaskCateModel::findById($cate['pid']);
            $view = array(
                'cate'        => $cate,
                'parent_cate' => $parentCate
            );
        }
        return $this->theme->scope('manage.industryInfo', $view)->render();
    }

    
    public function postIndustryInfo(Request $request)
    {
        $file = $request->file('pic');
        if (!$file) {
            $cate = TaskCateModel::findById($request->get('id'));
            $pic = $cate['pic'];
        }else{
            $result = \FileClass::uploadFile($file,'sys');
            $result = json_decode($result,true);
            $pic = $result['data']['url'];
        }
        $arr = array(
            'pic' => $pic
        );
        $res = TaskCateModel::where('id',$request->get('id'))->update($arr);

        if($res){
            
            Cache::forget('task_cate');
            return redirect('manage/industry')->with(array('message' => '操作成功'));
        }

    }
}
