<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/20
 * Time: 下午 06:58
 */

namespace App\Http\Controllers\Courses;
use App\Http\Controllers\Controller;
use App\Repositories\Courses\ActivityRepositories;
use App\Repositories\Courses\CategoryRepositories;
use App\Repositories\Courses\SchoolRepositories;
use App\Repositories\Courses\SeriesRepositories;
use Illuminate\Http\Request;
use App\FileUpload\FileUpload;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    private  $schoolRepositories;
    private  $categoryRepositories;
    private  $activityRepositories;
    private  $seriesRepositories;
    private  $fileUpload;
    public function __construct(SeriesRepositories $seriesRepositories,SchoolRepositories $schoolRepositories,ActivityRepositories $activityRepositories,Request $request,FileUpload $fileUpload,CategoryRepositories $categoryRepositories)
    {
        $this->seriesRepositories = $seriesRepositories;
        $this->schoolRepositories = $schoolRepositories;
        $this->activityRepositories = $activityRepositories;
        $this->categoryRepositories = $categoryRepositories;
        $this->fileUpload = $fileUpload;
        $this->request = $request;
    }

    public function activityList(Request $request)
    {
        $data =array(
            'activitylist' => $this->activityRepositories->getActivityList($request->get("page"),$request->get("key")),
            'pageNow'=> !trim($request->get("page"))?1:$request->get("page"),
            'pageNumber'=>$this->activityRepositories->getActivityPage(),
            'listNumber'=>$this->activityRepositories->getActivityNumber(),
            'key'=>Input::get("key"),
        );
        return view("admin.courses.activity-list",$data);
    }

    public function edit(Request $request)//编辑页面函数
    {
        $activity =$this->activityRepositories->getActivityById($request->get('id'));
        $activity->repetition = json_decode($activity->repetition_period,true);
        $data =array(
            'schoollist'=>$this->schoolRepositories->getSchoolList('all'),
            'serieslist'=>$this->seriesRepositories->getSeriesList('all'),
            'activity' => $activity,
            'catelist'=>$this->categoryRepositories->getCategoryList('all'),
            'id'=>$this->request->get('id')
        );
        return view("admin.courses.activity-edit",$data);
    }

    public function add(){
        $data = array(
            'serieslist' => $this->seriesRepositories->getSeriesList('all'),
            'catelist'=>$this->categoryRepositories->getCategoryList('all'),
            'schoollist'=>$this->schoolRepositories->getSchoolList('all')
        );
        return view("admin.courses.activity-add",$data);
    }

    public function activityEdit()
    {//ajax编辑
        $id=$this->request->post('id');
        $activity_name = $this->request->post('activity_name');
        $phone = $this->request->post('phone');
        $start_time = $this->request->post('start_time');
        $end_time = $this->request->post('end_time');
        $activity_des = $this->request->post('activity_des');
        $sign_up_ple_max = $this->request->post('sign_up_ple_max');
        $category_id = $this->request->post('category_id');
        $activity_img = $this->request->post('activity_img');
        $school_id = $this->request->post('school_id');
        $label = $this->request->post('label');
        $lat = $this->request->post('lat');
        $lng = $this->request->post('lng');
        $pay_money = $this->request->post('pay_money');
        $activity_address = $this->request->post('activity_address');
        $enclosure = $this->request->post('addFilelist');
        $material = $this->request->post('material');
        $up_user_name = $this->request->post('up_user_name');
        $series_id = $this->request->post('series_id');
        if ($start_time>$end_time){
            show(0,"活动开始日期不能大于结束日期");
        }
        if (!$activity_name){
            show(0,"请输入活动名称");
        }

        if (!$id){
            show(0,"非法的id");
        }
        if (!trim($category_id)){
            show(0,"请选择分类");
        }

        if (!trim($lat)||!trim($lng)){
            show(0,"请点击地图");
        }
        if (!$sign_up_ple_max){
            show(0,"请输入活动最大人数");
        }
        if (!$school_id){
            show(0,"请选择学校");
        }
        if ($this->request->post('is_real_name_registration')=='on'){
            $is_real_name_registration = 1;
        }else{
            $is_real_name_registration = 0;
        }
        if ($this->request->post('is_open')=='on'){
            $is_open = 1;
        }else{
            $is_open = 0;
        }
        if (!trim($activity_name)){
            show(0,"请填写分类名称");
        }
        Db::beginTransaction();
        $data = array(
            'pay_money'=>$pay_money,
            'material'=>$material,
            'up_user_name'=>$up_user_name,
            'school_id'=>$school_id,
            'phone'=>$phone,
            'activity_img'=>$activity_img,
            'activity_name' => $activity_name,
            'start_time' => $start_time,
            'activity_address'=>$activity_address,
            'end_time' => $end_time,
            'enclosure'=>$enclosure,
            'activity_des' => $activity_des,
            'sign_up_ple_max' => $sign_up_ple_max,
            'sign_up_ple_now' => 0,
            'up_user_name' => "admin",
            'up_user_id'=>0,
            'is_open' => $is_open,
            'category_id'=>$category_id,
            'is_real_name_registration' => $is_real_name_registration,//是否要求用户实名报名
            'lat'=>$lat,
            'lng'=>$lng,
            'is_pass'=>1,
            'series_id'=>$series_id,
            'repetition_period'=>json_encode($label),
        );
        $res = $this->activityRepositories->setActivityById($data,$id);
        if ($res) {
            Db::commit();
            show(1,"修改成功");
        } else {
            Db::rollBack();
            show(0,"修改失败");
        }
    }

    public function activityDel(Request $request)
    {
        $res = $this->activityRepositories->delActivityById($request->get('id'));
        if ($res) {
            return response()->json(['status' => 1, 'msg' => '删除成功']);
        } else {
            return response()->json(['status' => 1, 'msg' => '删除条目成功但文件未能完全删除，肯能文件已经不存在或者文件夹没有权限']);
        }
    }

    public function activityAdd(Request $request){
        $activity_name = $this->request->post('activity_name');
        $phone = $this->request->post('phone');
        $start_time = $this->request->post('start_time');
        $end_time = $this->request->post('end_time');
        $activity_des = $this->request->post('activity_des');
        $sign_up_ple_max = $this->request->post('sign_up_ple_max');
        $category_id = $this->request->post('category_id');
        $activity_img = $this->request->post('activity_img');
        $school_id = $this->request->post('school_id');
        $label = $this->request->post('label');
        $lat = $this->request->post('lat');
        $lng = $this->request->post('lng');
        $pay_money = $this->request->post('pay_money');
        $activity_address = $this->request->post('activity_address');
        $enclosure = $this->request->post('addFilelist');
        $material = $this->request->post('material');
        $up_user_name = $this->request->post('up_user_name');
        $series_id = $this->request->post('series_id');
        if ($start_time>$end_time){
            show(0,"活动开始日期不能大于结束日期");
        }
        if (!$activity_name){
            show(0,"请输入活动名称");
        }

        if (!trim($category_id)){
            show(0,"请选择分类");
        }

        if (!trim($lat)||!trim($lng)){
            show(0,"请点击地图");
        }
        if (!$sign_up_ple_max){
            show(0,"请输入活动最大人数");
        }

        if (!$school_id){
            show(0,"请选择学校");
        }

        if ($this->request->post('is_real_name_registration')=='on'){
            $is_real_name_registration = 1;
        }else{
            $is_real_name_registration = 0;
        }

        if ($this->request->post('is_open')=='on'){
            $is_open = 1;
        }else{
            $is_open = 0;
        }
        if (!trim($activity_name)){
            show(0,"请填写分类名称");
        }
        Db::beginTransaction();
        $data = array(
        'pay_money'=>$pay_money,
            'material'=>$material,
            'up_user_name'=>$up_user_name,
            'school_id'=>$school_id,
            'phone'=>$phone,
            'activity_img'=>$activity_img,
            'activity_name' => $activity_name,
            'start_time' => $start_time,
            'activity_address'=>$activity_address,
            'end_time' => $end_time,
            'enclosure'=>$enclosure,
            'activity_des' => $activity_des,
            'sign_up_ple_max' => $sign_up_ple_max,
            'sign_up_ple_now' => 0,
            'up_user_name' => "admin",
            'up_user_id'=>0,
            'is_open' => $is_open,
            'category_id'=>$category_id,
            'is_real_name_registration' => $is_real_name_registration,//是否要求用户实名报名
            'lat'=>$lat,
            'lng'=>$lng,
            'is_pass'=>1,
            'series_id'=>$series_id,
            'repetition_period'=>json_encode($label),
            'add_time'=>time(),
        );
        $res = $this->activityRepositories->addActivity($data);
        if ($res) {
            Db::commit();
            show(1,"添加成功");
        } else {
            Db::rollBack();
            show(0,"添加失败");
        }
    }

    public function uploadActivityImg(){
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

    public function uploadActivityFollow(){
        $uploadPath = "Follow";
        $file = $this->request->file('file');
        if (!trim($file)){
            show(0,"文件不能为空");
        }
        $imgPath = $this->fileUpload->uploadFile($file,$uploadPath);
        if (!$imgPath){
            show(0,"上传图片失败");
        }
        show(1,"上传成功",$imgPath);
    }

    public function uploadActivityDesImg(Request $request)
    {
        $uploadPath = "activityDes";
        $file = $this->request->file('file');
        if (!trim($file)){
            show(0,"文件不能为空");
        }
        $imgPath = $this->fileUpload->uploadImgFile($file,$uploadPath);
        if (!$imgPath){
            return response()->json(['code' => 1, 'msg' => '图片保存失败', 'data' => '文件保存失败']);
        }
        return response()->json(['code' => 0, 'msg' => '200', 'data' => $imgPath]);
    }
}
