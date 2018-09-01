<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\AdminPermissionsRespository;
use App\Repositories\Admin\AdminUserRepository;
use App\Repositories\Admin\AdminRolesRespository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    protected $adminUserRepository;

    protected $adminRolesRespository;

    protected $adminPermissionsRespository;

    protected $request;

    public function __construct(AdminRolesRespository $adminRolesRespository,AdminUserRepository $adminUserRepository, AdminPermissionsRespository $adminPermissionsRespository, Request $request)
    {
        $this->adminUserRepository = $adminUserRepository;
        $this->request = $request;
        $this->adminRolesRespository = $adminRolesRespository;
        $this->adminPermissionsRespository = $adminPermissionsRespository;
    }

    public function login()
    {
        if($this->request->method() == 'POST')
        {
            $username = $this->request->username;
            $password = $this->request->password;
            $adminUser = $this->adminUserRepository->findBy(['username'=>$username]);
            if($adminUser)
            {
                //验证密码是否正确
                if($adminUser->password == $password)
                {
                    $permissions = [];
                    if($adminUser->is_admin==0)
                    {
                        $this->adminRolesRespository->setField(['permissions']);
                        //查询用户自有权限
                        $permissions = implode(',',$adminUser->permissions);
                        //查询角色拥有权限
                        $rolesPermissions = $this->adminRolesRespository->findBy(['id'=>$adminUser->roles_id]);
                        $permissions = $permissions + $rolesPermissions;
                        $permissions = json_decode(json_encode($permissions),true);
                        //查询对应的权限路由
                        $this->adminPermissionsRespository->findBy(['id','in',$permissions]);
                    }
                    //存储权限
                    Session::put('userInfo',json_encode(['info'=>$adminUser,'permissions'=>array_values($permissions)]));
                    return response()->json(['status'=>1,'msg'=>'登陆成功']);
                }else{
                    return response()->json(['status'=>0,'msg'=>'密码错误,请重新输入！']);
                }
            }else{
                return response()->json(['status'=>0,'msg'=>'用户不存在']);
            }
        }else{
            return view('admin.login');
        }
    }

    public function outLogin(){
        if ($this->request->method()=='POST'){
            if (Session::pull('userInfo')){//判断是否已经登录
                return response()->json(['status'=>1,'msg'=>'退出登录成功']);
            }else{
                return response()->json(['status'=>0,'msg'=>'您没有登录']);
            }
        }
        else if ($this->request->method()=='GET'){
            if (Session::pull('userInfo')){//判断是否已经登录
                return '退出登录成功';
            }else{
                return '您没有登录';
            }
        }
    }
}
