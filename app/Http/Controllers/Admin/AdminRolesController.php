<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\AdminRolesRespository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminRolesController extends Controller
{
    private $adminRolesRespository;

    protected $request;

    public function __construct(AdminRolesRespository $adminRolesRespository, Request $request)
    {
        $this->adminRolesRespository = $adminRolesRespository;
        $this->request = $request;
    }

   public function rolesList(Request $request)
    {
        $data =array(
            'roleslist' => $this->adminRolesRespository->getRolesList($request->get("page"),$request->get("key")),
            'pageNow'=> !trim($request->get("page"))?1:$request->get("page"),
            'pageNumber'=>$this->adminRolesRespository->getRolesPage(),
            'listNumber'=>$this->adminRolesRespository->getRolesNumber(),
            'key'=>Input::get("key"),
        );
        return view("admin.user.user-roles-list",$data);
    }

    public function edit(Request $request)//编辑页面函数
    {
        $data =array(
            'roles' => $this->adminRolesRespository->getRolesById($request->get('id')),
            'id'=>$this->request->get('id')
        );
        return view("admin.user.user-roles-edit",$data);
    }

    public function add(){
        return view("admin.user.user-roles-add");
    }

    public function rolesEdit(Request $request)
    {//ajax编辑用户
        $data = array(
            'names' => $request->post('names'),
            'permissions' => $request->post('permissions'),
        );

        if ($request->post('id') == 'add') {
            $res = $this->adminRolesRespository->addRoles($data);
        } else {
            $res = $this->adminRolesRespository->setRolesById($request->post('id'), $data);
        }

        if ($res) {
            return response()->json(['status' => 1, "msg" => "修改成功"]);
        } else {
            return response()->json(['status' => 0, "msg" => "修改失败"]);
        }
    }

    public function rolesDel(Request $request){
        $res = $this->adminRolesRespository->delRolesById($request->get('id'));
        if ($res){
            return response()->json(['status'=>1,'msg'=>'删除成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'删除失败']);
        }
    }

    public function rolesAdd(Request $request){
        $data = array(
            'permissions' => $request->post('permissions'),
            'names' => $request->post('names'),
            'add_time'=>time(),
        );
        $res = $this->adminRolesRespository->addRoles($data);
        if ($res) {
            return response()->json(['status' => 1, "msg" => "添加成功"]);
        } else {
            return response()->json(['status' => 0, "msg" => "添加失败"]);
        }
    }
}
