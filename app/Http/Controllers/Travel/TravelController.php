<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/28
 * Time: 上午 10:18
 */

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\Controller;
use App\Repositories\Travel\TravelRepository;
use App\Repositories\UserRepositories;
use App\Repositories\Courses\ActivityRepositories;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    protected $request;
    private $userRepositories;
    private $activityRepositories;
    private $travelRepository;

    public function __construct(ActivityRepositories $activityRepositories,UserRepositories $userRepositories,TravelRepository $travelRepository,Request $request)
    {
        $this->activityRepositories = $activityRepositories;
        $this->userRepositories = $userRepositories;
        $this->travelRepository = $travelRepository;
        $this->request = $request;
    }

    public function travelList(Request $request)
    {
        $data =array(
            'travellist' => $this->travelRepository->getTravelList($request->get("page"),$request->get("key")),
            'pageNow'=> !trim($request->get("page"))?1:$request->get("page"),
            'pageNumber'=>$this->travelRepository->getPageNum(),
            'listNumber'=>$this->travelRepository->getCoutNumber(),
            'key'=>$this->request->get("key"),
        );
        return view("admin.travel.travel-list",$data);
    }

    public function edit(Request $request)//编辑页面函数
    {
        $id = $request->get('id');
        $data = array(
            'travel' => $this->travelRepository->getTravelById($id),
            'id'=>$id
        );
        return view("admin.travel.travel-edit",$data);
    }

    public function add(){
        $data = array(
            'activitylist'=>$this->activityRepositories->getActivityList('all'),
            'userlist'=>$this->userRepositories->getUserList(''),
        );
        return view("admin.travel.travel-add",$data);
    }

    public function travelEdit()
    {//ajax编辑
        $id = $this->request->post('id');
        $travel_name = $this->request->post('travel_name');
        if (!trim($travel_name)){
            show(0,"请填写分类名称");
        }
        $data = array(
            'travel_name' => $travel_name,
        );
        $res = $this->travelRepository->edit(['id'=>$id], $data);
        if ($res) {
            show(1,"修改成功");
        } else {
            show(0,"修改失败");
        }
    }

    public function travelDel(Request $request)
    {
        $id = $request->get('id');
        $res = $this->travelRepository->del(['id'=>$id]);
        if ($res) {
            return response()->json(['status' => 1, 'msg' => '删除成功']);
        } else {
            return response()->json(['status' => 1, 'msg' => '删除条目成功但文件未能完全删除，肯能文件已经不存在或者文件夹没有权限']);
        }
    }

    public function travelAdd(Request $request){
        $activity_id = $this->request->post('activity_id');
        $user_id = $this->request->post('user_id');
        if (!trim($activity_id)){
            show(0,"请选择活动");
        }
        if (!trim($user_id)){
            show(0,"请选择用户");
        }
        $data = array(
            'activity_id' => $activity_id,
            'user_id' => $user_id,
            'add_time'=>time(),
        );
        $res = $this->travelRepository->add($data);
        if ($res) {
            show(1,"添加成功");
        } else {
            show(0,"添加失败");
        }
    }
}
