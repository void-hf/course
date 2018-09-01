<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
//分页
class IndexController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        return view('admin.index');
    }

    public function welcome()
    {
        return view('admin.layouts.main');
    }

    public function userList()
    {
        return view("admin.layouts.user-list");
    }
}
