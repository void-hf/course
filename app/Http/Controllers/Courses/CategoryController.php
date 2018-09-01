<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/07/28
 * Time: 上午 11:58
 */

namespace App\Http\Controllers\Courses;

use App\Repositories\Courses\CategoryRepositories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FileUpload\FileUpload;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class CategoryController extends Controller
{
    protected $request;
    private $fileUpload;
    private $categoryRepositories;

    public function __construct(CategoryRepositories $categoryRepositories,Request $request,FileUpload $fileUpload)
    {
        $this->categoryRepositories = $categoryRepositories;
        $this->fileUpload = $fileUpload;
        $this->request = $request;
    }

    public function categoryList(Request $request)
    {
        $data =array(
            'categorylist' => $this->categoryRepositories->getCategoryList($request->get("page"),$request->get("key")),
            'pageNow'=> !trim($request->get("page"))?1:$request->get("page"),
            'pageNumber'=>$this->categoryRepositories->getCategoryPage(),
            'listNumber'=>$this->categoryRepositories->getCategoryNumber(),
            'key'=>Input::get("key"),
        );
        return view("admin.courses.category-list",$data);
    }

    public function edit(Request $request)//编辑页面函数
    {
        $data =array(
            'category' => $this->categoryRepositories->getCategoryById($request->get('id')),
            'id'=>$this->request->get('id')
        );
        return view("admin.courses.category-edit",$data);
    }

    public function add(){
        return view("admin.courses.category-add");
    }

    public function categoryEdit()
    {//ajax编辑
        $id = $this->request->post('id');
        $category_name = $this->request->post('category_name');
        $category_img = $this->request->post('category_img');
        $sort_val = $this->request->post('sort_val');

        if (!trim($category_name)){
            show(0,"请填写分类名称");
        }
        $data = array(
            'category_name' => $category_name,
            'category_img' => $category_img,
            'sort_val' => $sort_val,
        );
        $res = $this->categoryRepositories->setCategoryById($id, $data);
        if ($res) {
            show(1,"修改成功");
        } else {
            show(0,"修改失败");
        }
    }

    public function categoryDel(Request $request)
    {
        $res = $this->categoryRepositories->delCategoryById($request->get('id'));
        if ($res) {
            return response()->json(['status' => 1, 'msg' => '删除成功']);
        } else {
            return response()->json(['status' => 1, 'msg' => '删除条目成功但文件未能完全删除，肯能文件已经不存在或者文件夹没有权限']);
        }
    }

    public function categoryAdd(Request $request){

        $category_name = $this->request->post('category_name');
        $category_img = $this->request->post('category_img');
        $sort_val = $this->request->post('sort_val');
        if (!trim($category_name)){
            show(0,"请填写分类名称");
        }
        $data = array(
            'category_name' => $category_name,
            'category_img' => $category_img,
            'sort_val' => $sort_val,
            'add_time'=>time(),
        );
        $res = $this->categoryRepositories->addCategory($data);
        if ($res) {
            show(1,"添加成功");
        } else {
            show(0,"添加成功");
        }
    }

    public function uploadCategoryImg(){
        $uploadPath = "Categorry";
        $file = $this->request->file('file');
        if (!trim($file)){
            show(0,"文件不能为空");
        }
        $imgPath = $this->fileUpload->uploadImgFile($file,$uploadPath);
        if (!$imgPath){
            show(0,"上传图片失败");
        }
        show(1,"上传成功",['src'=>$imgPath['src']]);
    }
}
