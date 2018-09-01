<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminAuthVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userInfo = json_decode(session('userInfo'));
        if($userInfo)
        {
            //判断是否为管理员,如果是直接放行
            if($userInfo->info->is_admin == 1)
            {
                return $next($request);
            }else{
                //验证路由权限
                $routeName = $request->route()->getName();
            }
        }else{
            return redirect('/admin/login');
        }
        return $next($request);
    }
}
