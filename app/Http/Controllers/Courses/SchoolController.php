<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/20
 * Time: 下午 05:37
 */

namespace App\Http\Controllers\Courses;
use App\Repositories\Courses\SchoolRepositories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    protected $request;
    private $schoolRepositories;

    public function __construct(SchoolRepositories $schoolRepositories,Request $request)
    {
        $this->schoolRepositories = $schoolRepositories;
        $this->request = $request;
    }

    public function schoolList(Request $request)
    {
        $data =array(
            'schoollist' => $this->schoolRepositories->getSchoolList($request->get("page"),$request->get("key")),
            'pageNow'=> !trim($request->get("page"))?1:$request->get("page"),
            'pageNumber'=>$this->schoolRepositories->getSchoolPage(),
            'listNumber'=>$this->schoolRepositories->getSchoolNumber(),
            'key'=>$this->request->get("key"),
        );
        return view("admin.courses.school-list",$data);
    }

    public function edit(Request $request)//编辑页面函数
    {
        $data =array(
            'school' => $this->schoolRepositories->getSchoolById($request->get('id')),
            'id'=>$this->request->get('id')
        );
        return view("admin.courses.school-edit",$data);
    }

    public function add(){
        return view("admin.courses.school-add");
    }

    public function schoolEdit()
    {//ajax编辑
        $id = $this->request->post('id');
        $school_name = $this->request->post('school_name');

        if (!trim($school_name)){
            show(0,"请填写分类名称");
        }
        $data = array(
            'school_name' => $school_name,
        );
        $res = $this->schoolRepositories->setSchoolById($id, $data);
        if ($res) {
            show(1,"修改成功");
        } else {
            show(0,"修改失败");
        }
    }

    public function schoolDel(Request $request)
    {
        $res = $this->schoolRepositories->delSchoolById($request->get('id'));
        if ($res) {
            return response()->json(['status' => 1, 'msg' => '删除成功']);
        } else {
            return response()->json(['status' => 1, 'msg' => '删除条目成功但文件未能完全删除，肯能文件已经不存在或者文件夹没有权限']);
        }
    }

    public function schoolAdd(Request $request){
        $school_name = $this->request->post('school_name');
        if (!trim($school_name)){
            show(0,"请填写分类名称");
        }
        $data = array(
            'school_name' => $school_name,
            'add_time'=>time(),
        );
        $res = $this->schoolRepositories->addSchool($data);
        if ($res) {
            show(1,"添加成功");
        } else {
            show(0,"添加成功");
        }
    }
}
