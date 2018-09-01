<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/29
 * Time: 下午 07:41
 */

namespace App\Http\Controllers\WxInterface;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositories;
use App\Repositories\Commentay;
use App\Service\WxchatService;
use Illuminate\Http\Request;
use App\Service\RedisService;
use App\Service\Message;
use Illuminate\Support\Facades\Redis;

class WxCommentayController extends Controller
{
    private $request;
    private $commentay;
    private $userRepositories;
    private $wxchatService;
    private $redisService;
    private $message;

    public function __construct(
        UserRepositories $userRepositories,
        RedisService $redisService,
        Request $request,
        WxchatService $wxchatService,
        Commentay\CommentayRepository $commentay,
        Message $message
    )
    {
        $this->commentay = $commentay;
        $this->userRepositories = $userRepositories;
        $this->redisService = $redisService;
        $this->wxchatService = $wxchatService;
        $this->message = $message;
        $this->request = $request;
    }

    public function addCommentayBy()//添加活动对应的评论或者回复对应的评论
    {
        $token = $this->request->post("token");
        $content = $this->request->post("content");//评论内容
        $activity_id = $this->request->post("activity_id");//活动的id
        $commentay_id = $this->request->post("comment_id");//活动的id

        if (!trim($activity_id)&&!trim($commentay_id)){
            return eShow($this->message->eActivityidAndCommentayidNull);
        }

        if (trim($activity_id)&&trim($commentay_id)){
            return eShow($this->message->eActivityidAndCommentayidIs);
        }

        if (!trim($activity_id)) {
            $activity_id =0;
        }
        if (!trim($commentay_id)) {
            $commentay_id = 0;
        }
        if (!trim($token)) {
            return eShow($this->message->eUserIsToken);
        }
        if (!trim($content)) {
            return eShow($this->message->eUserNullContent);
        }

        $user_id = $this->userRepositories->checkToken($token);
        $user = $this->userRepositories->getUserById($user_id);

        if (!$user_id) {
            return eShow($this->message->eUserIsLogin);
        }

        $data = array(
            'comment_id' => $commentay_id,
            'activity_id' => $activity_id,
            'content' => $content,
            'user_id' => $user_id,
            'user_name' => $user->user_name,
            'add_time' => time()
        );
        if (!$this->commentay->addCommentay($data)) {
            return eShow($this->message->eAddError);
        }
        return show(20000, "添加成功");
    }

    public function getCommentayByActivityId()
    {//获取更多评论信息
        $offset = $this->request->post("offset");
        $size = $this->request->post("size");
        $page = $this->request->post("page");
        $activity_id = $this->request->post("activity_id");

        if (!trim($activity_id)){
            eShow($this->message->eActivityidNullId);
        }

        if (!trim($offset)) {
            $offset = 0;
        }
        if (!trim($size)) {
            $size = 5;
        }
        if (!trim($page)) {
            $page = 1;
        }
        $commentayList = json_decode($this->commentay->getCommentays($offset, $size, $page, $activity_id));
        if (!$commentayList) {
            return eShow($this->message->eGetError);
        }
        foreach ($commentayList as $key => $value) {
                $commentayList[$key]->Reply = $this->commentay->getReplyListByCommentayId($value->id);
        }
        return show(20000, "获取评论列表成功", $commentayList);
    }

}
