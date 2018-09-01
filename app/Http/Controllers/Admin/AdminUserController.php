<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\AdminUserRepository;
use App\Repositories\Admin\AdminPermissionsRespository;
use App\Repositories\Admin\AdminRolesRespository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminUserController extends Controller
{
    protected $adminUserRespository;
    protected $adminPermissionsRespository;
    protected $adminRolesRespository;
    protected $request;

    public function __construct(
        AdminUserRepository $adminUserRepository,
        AdminPermissionsRespository $adminPermissionsRespository,
        AdminRolesRespository $adminRolesRespository,
        Request $request
    )
    {
        $this->adminUserRespository = $adminUserRepository;
        $this->adminPermissionsRespository = $adminPermissionsRespository;
        $this->adminRolesRespository = $adminRolesRespository;
        $this->request = $request;
    }

    public function userList(Request $request)
    {
        $data = array(
            'list' => $this->adminUserRespository->getUserList($request->get("page"), $request->get("key")),
            'pageNow' => !trim($request->get("page")) ? 1 : $request->get("page"),
            'pageNumber' => $this->adminUserRespository->getUserPage(),
            'listNumber' => $this->adminUserRespository->getUserNumber(),
            'key' => Input::get("key"),
        );
        return view("admin.user.user-list", $data);
    }

    public function edit(Request $request)//编辑页面函数
    {
        $data = array(
            'roleslist' => $this->adminRolesRespository->getRolesList('all'),
            'permissionslist' => $this->adminPermissionsRespository->getPermissionsPage('all'),
            'user' => $this->adminUserRespository->getUserById($request->get('id')),
            'id' => $this->request->get('id')
        );
        return view("admin.user.user-edit", $data);
    }

    public function add()
    {
        $data = array(
            'roleslist' => $this->adminRolesRespository->getRolesList('all'),
            'permissionslist' => $this->adminPermissionsRespository->getPermissionsPage('all'),
        );
        return view("admin.user.user-add",$data);
    }

    public function userEdit(Request $request)//ajax编辑用户
    {
        if ($request->post('password') != $request->post('en_password')) {
            return response()->json(['status' => 0, 'msg' => "请确实两次输入的密码是否一致"]);
        }
        $data = array(
            'username' => $request->post('username'),
            'password' => $request->post('password'),
            'roles' => $request->post('roles'),
            'permissions' => $request->post('permissions'),
        );
        if ($request->post('id') == 'add') {
            $res = $this->adminUserRespository->addUser($data);
        } else {
            $res = $this->adminUserRespository->setUserById($request->post('id'), $data);
        }
        if ($res) {
            return response()->json(['status' => 1, "msg" => "修改成功"]);
        } else {
            return response()->json(['status' => 0, "msg" => "修改失败"]);
        }
    }

    public function userDel(Request $request)
    {
        $res = $this->adminUserRespository->delUserById($request->get('id'));
        if ($res) {
            return response()->json(['status' => 1, 'msg' => '删除成功']);
        } else {
            return response()->json(['status' => 0, 'msg' => '删除失败']);
        }
    }

    public function userAdd(Request $request)
    {

        if ($this->adminUserRespository->getUserByName($request->post("username"))) {
            return response()->json(['status' => 0, "msg" => "用户名已经存在"]);
        }
        if ($request->post('password') != $request->post('en_password')) {
            return response()->json(['status' => 0, "msg" => "两次输入的密码不正确请重新输入密码"]);
        }

        if (!trim((string)$request->post('is_admin'))) {
            return response()->json(['status' => 0, "msg" => "请选择是否管理员"]);
        }

        if (!trim((string)$request->post('roles'))) {
            return response()->json(['status' => 0, "msg" => "请填写角色"]);
        }

        if (!trim((string)$request->post('permissions'))) {
            return response()->json(['status' => 0, "msg" => "请填写权限"]);
        }

        $data = array(
            'username' => $request->post('username'),
            'password' => $request->post('password'),
            'is_admin' => $request->post('is_admin') - 1,
            'add_time' => time(),
            'roles' => $request->post('roles'),
            'permissions' => $request->post('permissions'),
        );

        $res = $this->adminUserRespository->addUser($data);

        if ($res) {
            return response()->json(['status' => 1, "msg" => "添加成功"]);
        } else {
            return response()->json(['status' => 0, "msg" => "添加失败"]);
        }
    }

    public function userEditIsAdmin(Request $request)
    {
        $res = $this->adminUserRespository->setUserById($request->post('id'), ['is_admin' => $request->post('is_admin')]);
        if ($res) {
            return response()->json(['status' => 1, "msg" => "修改成功"]);
        } else {
            return response()->json(['status' => 0, "msg" => "修改失败"]);
        }
    }
}
