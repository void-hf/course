<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|_________________________________________________________________________
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
    Route::any('/userReg', 'WxInterface\WxInterfaceController@userReg');
});

Route::any('/userReg', 'WxInterface\WxUserController@userReg');//用户注册

Route::any('/addCommentayBy', 'WxInterface\WxCommentayController@addCommentayBy');//添加评论

Route::any('/getCommentayByActivityId', 'WxInterface\WxCommentayController@getCommentayByActivityId');//获取评论列表

Route::any('/addUserBrowse', 'WxInterface\WxActivityController@addUserBrowse');//添加到用户浏览信息

Route::any('/selectActivityByKey', 'WxInterface\WxActivityController@selectActivityByKey');//根据关键词获取相关的活动信息

Route::any('/debugTime', 'WxInterface\WxActivityController@debugTime');//debug

