<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\AdminPermissionsRespository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminPermissionsController extends Controller
{
    protected $adminPermissionsRespository;
    protected $request;
    public function __construct(AdminPermissionsRespository $adminPermissionsRespository,Request $request)
    {
        $this->adminPermissionsRespository = $adminPermissionsRespository;
        $this->request=$request;
    }

    public function permissionsList(){//根据分页获取固定范围的权限
        $data =array(
            'permissionlist' => $this->adminPermissionsRespository->getPermissionsList($this->request->get("page"),$this->request->get("key")),
            'pageNow'=> !trim($this->request->get("page"))?1:$this->request->get("page"),
            'pageNumber'=>$this->adminPermissionsRespository->getPermissionsPage(),
            'listNumber'=>$this->adminPermissionsRespository->getPermissionsNumber(),
            'key'=>Input::get("key"),
        );
        return view("admin.user.user-permission-list",$data);
    }

    public function edit(Request $request)//编辑页面函数
    {
        $data =array(
            'permission' => $this->adminPermissionsRespository->getPermissionsById($request->get('id')),
            'id'=>$this->request->get('id')
        );
        return view("admin.user.user-permission-edit",$data);
    }

    public function add(Request $request){
        return view("admin.user.user-permission-add");
    }

    public function permissionsEdit (Request $request)
    {//ajax编辑用户
        if ($request->post('password') != $request->post('en_password')) {
            return response()->json(['status' => 0, 'msg' => "请确实两次输入的密码是否一致"]);
        }
        $data = array(
            'names' => $request->post('names'),
            'route_name' => $request->post('route_name'),
        );

        if ($request->post('id') == 'add') {
            $res = $this->adminPermissionsRespository->addPermissions($data);
        } else {
            $res = $this->adminPermissionsRespository->setPermissionsById($request->post('id'), $data);
        }

        if ($res) {
            return response()->json(['status' => 1, "msg" => "修改成功"]);
        } else {
            return response()->json(['status' => 0, "msg" => "修改失败"]);
        }
    }

    public function permissionsDel(Request $request){
        $res = $this->adminPermissionsRespository->delPermissionsById($request->get('id'));
        if ($res){
            return response()->json(['status'=>1,'msg'=>'删除成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'删除失败']);
        }
    }

    public function permissionsAdd(Request $request){
        $data = array(
            'route_name' => $request->post('route_name'),
            'names' => $request->post('names'),
            'add_time'=>time(),
        );
        $res = $this->adminPermissionsRespository->addPermissions($data);

        if ($res) {
            return response()->json(['status' => 1, "msg" => "添加成功"]);
        } else {
            return response()->json(['status' => 0, "msg" => "添加失败"]);
        }
    }
}
