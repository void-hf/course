<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/29
 * Time: 下午 03:04
 */

namespace App\Service;

use Illuminate\Http\Request;

class Message
{
    //////////////////////////////////////////////////////
    public $eUserReg = array('30001', '用户已经注册');

    public $eUserIsLogin = array('30002', '用户已经登陆');

    public $eUserIsToken = array('30003', '该是token无效的');

    public $eUserIsTokenOutTime = array('30004', '该token过期');

    public $eUserNullImg = array('30005', '用户头像不能为空');

    public $eUserNullName = array('30006', '用户名不能为空');

    public $eUserNullContent = array('30007', '内容不能为空');

    public $eUserNullActivityid = array('30008', '用户参与活动的id不能为空');

    public $eUserNullOpenid = array('30009', "openid不能为空");

    public $eGetUserOpenid = array('30010', "获取openid失败");
//////////////////////////////////////////////////////
    public $eActivityidNullId = array('30011', "活动id不能为空");

    public $eActivityidAndCommentayidNull = array('30012', "活动或者评论id不能为空");

    public $eActivityidAndCommentayidIs = array('30013', "活动id和评论id不能同时填写");

    public $eKeyNull = array('30014', "关键词不能为空");

    public $eUserNotReg = array('30008', '用户没有注册');

    ////////////////////////////////////////////////////////////////////

    public $eNotingData = array('40004', "没有查询到信息");

    public $eGetError = array('40005', "获取数据失败");

    public $eAddError = array('40006', "添加数据失败");

    public $eUserIsAdd = array('40007', "该数据已经添加");
}

