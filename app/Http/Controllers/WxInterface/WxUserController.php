<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/29
 * Time: 下午 04:22
 */

namespace App\Http\Controllers\WxInterface;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositories;
use App\Service\WxchatService;
use Illuminate\Http\Request;
use App\Service\RedisService;
use App\Service\Message;

class WxUserController extends Controller
{
    private $request;
    private $userRepositories;
    private $wxchatService;
    private $redisService;
    private $message;

    public function __construct(Message $message, RedisService $redisService, Request $request, WxchatService $wxchatService, UserRepositories $userRepositories)
    {
        $this->redisService = $redisService;
        $this->request = $request;
        $this->message = $message;
        $this->wxchatService = $wxchatService;
        $this->userRepositories = $userRepositories;
    }

    public function userReg()
    {
        $username = $this->request->post("user_name");//用户名
        $user_head_img = $this->request->post("user_head_img");//用户头像
        $openid = '';
        $code = $this->request->post('code');
        if (!trim($user_head_img)) {
           return eShow($this->message->eUserNullImg); //用户头像不能为空
        }
        if (!trim($username)) {
            return eShow($this->message->eUserNullName); //用户头像不能为空
        }
        if ($code == '111') {
            $openid = "windows";
        }
        if (!trim($openid)) {
            return eShow($this->message->eGetUserOpenid);
        }
        $user = $this->userRepositories->getUserByOpenId($openid);
        if ($user) {//判断用户已经注册
            $token = $this->redisService->findBy($user->id);
            if ($token) {
                return show(30012, "用户已经登录", ["isReg" => 1, "data" => ["opend_id" => $openid, "token" => $token]]);
            } else {
                $token = $this->wxchatService->creatToken('', time());
                $this->redisService->serGFile($token, $user->id);
                return show(20000, "用户获取token成功", ["isReg" => 1, "data" => ["opend_id" => $openid, "token" => $token]]);
            }
        }
        $data = array(
            'openid' => $openid,
            'user_name' => $username,
            'user_head_img' => $user_head_img,
            'reg_time' => time()
        );
        $res = $this->userRepositories->addUser($data);
        if ($res) {
            return show(2000, "用户注册成功");
        }
    }
    public function userLoginByOpenid()
    {
        $open_id = $this->request->post("oppend_id");
        if (!trim($open_id)) {
            return eShow($this->message->eUserNullOpenid);
        }
        $user = $this->userRepositories->getUserByOpenId($open_id);

        if (!$user) {
            return eShow($this->message->eUserNotReg);
        };
        $token = $this->redisService->findBy($user->id);//获取token
        if (trim($token)) {
            return show(20000, "获取成功", ['data' => $token]);
        }
        $token = $this->wxchatService->creatToken('', time());

        if ($this->redisService->serGFile($token,$user->id)) {
            return  show(20000, "获取token成功", ['token' => $token]);
        }
    }


}



