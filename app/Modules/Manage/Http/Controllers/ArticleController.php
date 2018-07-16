<?php
namespace App\Modules\Manage\Http\Controllers;

use App\Http\Controllers\BasicController;
use App\Http\Controllers\ManageController;
use App\Modules\Manage\Model\ArticleCategoryModel;
use App\Modules\Manage\Model\ArticleModel;
use App\Http\Requests;
use App\Modules\Manage\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Theme;
use Illuminate\Support\Facades\Auth;


class ArticleController extends ManageController
{
    public function __construct()
    {
        parent::__construct();
        $this->initTheme('manage');
        $this->theme->set('manageType', 'article');

    }

    
    public function articleList(Request $request, $upID)
    {
        
        $title = ArticleCategoryModel::where('id',$upID)->first()->cate_name;
        if($upID == 1){
            $this->theme->setTitle('文章管理');
        }elseif($upID == 3){
            $this->theme->setTitle('页脚管理');
        }
        $arr = $request->all();
        $upID = intval($upID);
        
        $m = ArticleCategoryModel::get()->toArray();
        $res = ArticleCategoryModel::_reSort($m,$upID);
        
        $articleList = ArticleModel::whereRaw('1 = 1');
        
        if ($request->get('catID')) {

            
            $r = ArticleCategoryModel::_children($m, $request->get('catID'));
            if (empty($r)) {
                $articleList = $articleList->where('article.cat_id', $request->get('catID'));
            } else {
                $catIds = array_merge($r, array($request->get('catID')));
                $articleList = $articleList->whereIn('article.cat_id', $catIds);
            }
        } else {
            
            $r = ArticleCategoryModel::_children($m, $upID);
            $catIds = array_merge($r, array($upID));
            $articleList = $articleList->whereIn('article.cat_id', $catIds);

        }
        
        if ($request->get('artID')) {
            $articleList = $articleList->where('article.id', $request->get('artID'));
        }
        
        if ($request->get('title')) {
            $articleList = $articleList->where('article.title', 'like', "%" . e($request->get('title')) . '%');
        }
        
        if ($request->get('author')) {
            $articleList = $articleList->where('article.author', 'like', '%' . e($request->get('author')) . '%');
        }
        if($request->get('start')){
            $start = date('Y-m-d H:i:s',strtotime($request->get('start')));
            $articleList = $articleList->where('article.created_at','>',$start);
        }
        if($request->get('end')){
            $end = date('Y-m-d H:i:s',strtotime($request->get('end')));
            $articleList = $articleList->where('article.created_at','<',$end);
        }
        $by = $request->get('by') ? $request->get('by') : 'article.created_at';
        $order = $request->get('order') ? $request->get('order') : 'desc';
        $paginate = $request->get('paginate') ? $request->get('paginate') : 10;


        $list = $articleList->join('article_category as c', 'article.cat_id', '=', 'c.id')
            ->select('article.id', 'article.cat_id', 'article.title', 'article.view_times', 'article.author', 'article.created_at', 'c.cate_name as cate_name')
            ->orderBy($by, $order)->paginate($paginate);
        $listArr = $list->toArray();

        $data = array(
            'merge' => $arr,
            'upID' => $upID,
            'artID' => $request->get('artID'),
            'title' => $request->get('title'),
            'catID' => $request->get('catID'),
            'author' => $request->get('author'),
            'paginate' => $request->get('paginate'),
            'order' => $request->get('order'),
            'by' => $request->get('by'),
            'article_data' => $listArr,
            'article' => $list,
            'category' => $res

        );
        return $this->theme->scope('manage.articlelist', $data)->render();

    }

    
    public function articleDelete($id, $upID)
    {
        $upID = intval($upID);
        switch($upID){
            case 1:
                $url = '/manage/article/';
                break;
            case 3:
                $url = '/manage/articleFooter/';
                break;
            default:
                $url = '/manage/article/';
        }
        $result = ArticleModel::where('id', $id)->delete();
        if (!$result) {
            return redirect()->to($url . $upID)->with(array('message' => '操作失败'));
        }
        return redirect()->to($url . $upID)->with(array('message' => '操作成功'));

    }

    
    public function allDelete(Request $request)
    {
        $data = $request->except('_token');

        $res = ArticleModel::destroy($data);
        if ($res) {
            return redirect()->to('/manage/article/1')->with(array('message' => '操作成功'));
        }
        return redirect()->to('/manage/article/1')->with(array('message' => '操作失败'));
    }

    
    public function addArticle(Request $request, $upID)
    {
        $upID = intval($upID);
        
        $title = ArticleCategoryModel::where('id',$upID)->first()->cate_name;
        $this->theme->setTitle('文章新建');
        
        $m = ArticleCategoryModel::get()->toArray();
        $res = ArticleCategoryModel::_reSort($m,$upID);
        $parentCate = ArticleCategoryModel::where('id',$upID)->first();
        $data = array(
            'category' => $res,
            'parent_cate' => $parentCate,
            'upID' => $upID
        );
        return $this->theme->scope('manage.addarticle', $data)->render();
    }

    
    public function postArticle(ArticleRequest $request)
    {
        
        $data = $request->except('_token', 'pic','upID');
        $upID = $request->get('upID');
        switch($upID){
            case 1:
                $url = '/manage/article/';
                break;
            case 3:
                $url = '/manage/articleFooter/';
                break;
            default:
                $url = '/manage/article/';
        }
        $data['cat_id'] = $data['catID'];
        $data['created_at'] = date('Y-m-d H:i:s',time());
        $data['updated_at'] = date('Y-m-d H:i:s',time());
        $data['display_order'] = $request->get('displayOrder');
        $data['content'] = htmlspecialchars($data['content']);
        if(mb_strlen($data['content']) > 4294967295/3){
            $error['content'] = '文章内容太长，建议减少上传图片';
            if (!empty($error)) {
                return redirect('/manage/addArticle')->withErrors($error);
            }
        }
        
        $res = ArticleModel::create($data);
        if ($res) {
            return redirect($url . $upID)->with(array('message' => '操作成功'));
        }
        return false;
    }

    
    public function editArticle(Request $request, $id, $upID)
    {
        $id = intval($id);
        $upID = intval($upID);
        
        $title = ArticleCategoryModel::where('id',$upID)->first()->cate_name;
        $this->theme->setTitle($title);
        $arr = ArticleCategoryModel::where('pid', $upID)->get()->toArray();
        foreach ($arr as $k => &$v) {
            $res = ArticleCategoryModel::where('pid', $v['id'])->get()->toArray();
            $arr[$k]['res'] = $res;
        }
        
        $m = ArticleCategoryModel::get()->toArray();
        $res = ArticleCategoryModel::_reSort($m,$upID);
        $parentCate = ArticleCategoryModel::where('id',$upID)->first();
        
        $article = ArticleModel::where('id', $id)->first();
        $data = array(
            'article' => $article,
            'parent_cate' => $parentCate,
            'upID' => $upID,
            'cate' => $res
        );
        $this->theme->setTitle('页脚编辑');
        return $this->theme->scope('manage.editarticle', $data)->render();
    }

    
    public function postEditArticle(ArticleRequest $request)
    {
        $data = $request->except('_token');
        switch($data['upID']){
            case 1:
                $url = '/manage/article/';
                break;
            case 3:
                $url = '/manage/articleFooter/';
                break;
            default:
                $url = '/manage/article/';
        }
        $data['content'] = htmlspecialchars($data['content']);
        if(mb_strlen($data['content']) > 4294967295/3){
            $error['content'] = '文章内容太长，建议减少上传图片';
            if (!empty($error)) {
                return redirect('/manage/addArticle')->withErrors($error);
            }
        }
        $arr = array(
            'title' => $data['title'],
            'cat_id' => $data['catID'],
            'author' => $data['author'],
            'display_order' => $data['displayOrder'],
            'content' => $data['content'],
            'summary' => $data['summary'],
            'seotitle' => $data['seotitle'],
            'keywords' => $data['keywords'],
            'description' => $data['description'],
            'updated_at' => date('Y-m-d H:i:s',time()),
        );
        
        $res = ArticleModel::where('id', $data['artID'])->update($arr);
        if ($res) {
            return redirect($url . $data['upID'])->with(array('message' => '操作成功'));
        }
    }


}
