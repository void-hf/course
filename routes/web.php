<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::any('/admin/login', 'Admin\LoginController@login');
Route::group(['middleware' => ['adminauth'], 'prefix' => 'admin'], function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::get('/index', 'Admin\IndexController@index');
    Route::get('/main', 'Admin\IndexController@welcome');
    ///////////////////////////////////////////////////////////////////////////////////////
    //用户后台
    Route::get('/user-list', 'Admin\AdminUserController@userList');
    Route::get('/user-edit', 'Admin\AdminUserController@edit');
    Route::get('/user-add', 'Admin\AdminUserController@add');
    //用户接口
    Route::post('/userEditById', 'Admin\AdminUserController@userEdit');
    Route::post('/userDelById', 'Admin\AdminUserController@userDel');
    Route::post('/userAddById', 'Admin\AdminUserController@userAdd');
    Route::post('/userEditIsAdminById', 'Admin\AdminUserController@userEditIsAdmin');
    ///////////////////////////////////////////////////////////////////////////////////////
    //权限后台
    Route::get('/permissions-list', 'Admin\AdminPermissionsController@permissionsList');
    Route::get('/permissions-edit', 'Admin\AdminPermissionsController@edit');
    Route::get('/permissions-add', 'Admin\AdminPermissionsController@add');
    //权限接口
    Route::post('/permissionsEditById', 'Admin\AdminPermissionsController@permissionsEdit');
    Route::post('/permissionsDelById', 'Admin\AdminPermissionsController@permissionsDel');
    Route::post('/permissionsAddById', 'Admin\AdminPermissionsController@permissionsAdd');
    ///////////////////////////////////////////////////////////////////////////////////////
    //角色后台
    Route::get('/roles-list', 'Admin\AdminRolesController@rolesList');
    Route::get('/roles-edit', 'Admin\AdminRolesController@edit');
    Route::get('/roles-add', 'Admin\AdminRolesController@add');
    //角色接口
    Route::post('/rolesEditById', 'Admin\AdminRolesController@rolesEdit');
    Route::post('/rolesDelById', 'Admin\AdminRolesController@rolesDel');
    Route::post('/rolesAddById', 'Admin\AdminRolesController@rolesAdd');

    ///////////////////////////////////////////////////////////////////////////////////////
    ///
    Route::group(['middleware' => ['adminauth'], 'prefix' => 'courses'], function () {
        //分类接口
        Route::get('/category-list', 'Courses\CategoryController@categoryList');
        Route::get('/category-edit', 'Courses\CategoryController@edit');
        Route::get('/category-add', 'Courses\CategoryController@add');
        //分类接口
        Route::post('/categoryEditById', 'Courses\CategoryController@categoryEdit');
        Route::post('/categoryDelById', 'Courses\CategoryController@categoryDel');
        Route::post('/categoryAddById', 'Courses\CategoryController@categoryAdd');
        Route::any('/uploadCategorylogo', 'Courses\CategoryController@uploadCategoryImg');//分类图片上传接口
        /////////////////////////////////////////////////////////////////////////////////////
        //学校接口
        Route::get('/school-list', 'Courses\SchoolController@schoolList');
        Route::get('/school-edit', 'Courses\SchoolController@edit');
        Route::get('/school-add', 'Courses\SchoolController@add');
        //学校接口
        Route::post('/schoolEditById', 'Courses\SchoolController@schoolEdit');
        Route::post('/schoolDelById', 'Courses\SchoolController@schoolDel');
        Route::post('/schoolAddById', 'Courses\SchoolController@schoolAdd');
        /////////////////////////////////////////////////////////////////////////////////////
        //活动系列接口
        Route::get('/series-list', 'Courses\SeriesController@seriesList');
        Route::get('/series-edit', 'Courses\SeriesController@edit');
        Route::get('/series-add', 'Courses\SeriesController@add');
        //活动系列接口
        Route::post('/seriesEditById', 'Courses\SeriesController@seriesEdit');
        Route::post('/seriesDelById', 'Courses\SeriesController@seriesDel');
        Route::post('/seriesAddById', 'Courses\SeriesController@seriesAdd');
        ///////////////////////////////////////////////////////////////////////////////////////
        //   活动接口
        Route::get('/activity-list', 'Courses\ActivityController@activityList');
        Route::get('/activity-edit', 'Courses\ActivityController@edit');
        Route::get('/activity-add', 'Courses\ActivityController@add');
        //    活动接口
        Route::post('/activityEditById', 'Courses\ActivityController@activityEdit');
        Route::post('/activityDelById', 'Courses\ActivityController@activityDel');
        Route::post('/activityAddById', 'Courses\ActivityController@activityAdd');
        Route::post('/uploadActivityFollow', 'Courses\ActivityController@uploadActivityFollow');//上传附件
        Route::post('/uploadActivityImg', 'Courses\ActivityController@uploadActivityImg');//上传图片
        Route::any('/uploadActivityDesImg', 'Courses\ActivityController@uploadActivityDesImg');//上传图片
    });
    /////////////////////////////////////////////////////////////////////////////////////////
    ///用户行程管理
    Route::group(['middleware' => ['adminauth'], 'prefix' => 'travel'], function () {
        /////////////////////////////////////////////////////////////////////////////////////
        //用户行程接口
        Route::get('/travel-list', 'Travel\TravelController@travelList');
        Route::get('/travel-edit', 'Travel\TravelController@edit');
        Route::get('/travel-add', 'Travel\TravelController@add');
        //用户行程接口
        Route::post('/travelEditById', 'Travel\TravelController@travelEdit');
        Route::post('/travelDelById', 'Travel\TravelController@travelDel');
        Route::post('/travelAddById', 'Travel\TravelController@travelAdd');
        ///////////////////////////////////////////////////////////////////////////////////////
    });
});
Route::post('/admin/outlogin', 'Admin\LoginController@outLogin');////退出登录接口
