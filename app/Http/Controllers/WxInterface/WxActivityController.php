<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/30
 * Time: 下午 05:39
 */

namespace App\Http\Controllers\WxInterface;

use App\Repositories\Courses\ActivityRepositories;
use App\Repositories\UserRepositories;
use App\Http\Controllers\Controller;
use App\Service\RedisService;
use App\Service\Message;
use Illuminate\Http\Request;
use function Psy\sh;

class WxActivityController extends Controller
{
    private $activityRepositories;
    private $userRepositories;
    private $request;
    private $message;
    private $redisService;

    public function __construct(
        UserRepositories $userRepositoriess,
        ActivityRepositories $activityRepositories,
        Request $request,
        Message $message,
        RedisService $redisService

    )
    {
        $this->request = $request;
        $this->message = $message;
        $this->userRepositories = $userRepositoriess;
        $this->redisService = $redisService;
        $this->activityRepositories = $activityRepositories;
    }

    public function selectActivityByKey()
    {//根据关键词获取活动信息
        $size = $this->request->post("size");
        $key = $this->request->post('key');
        if (!trim($size)) {
            $size = 6;
        }
        if (!trim($key)) {
            return eShow($this->message->eKeyNull);//关键词不能为空
        }
        $activitys = $this->activityRepositories->selectActivityByKey($size, $key);
        if (!$activitys) {
            return eShow($this->message->eGetError);//获取失败
        }
        return show(20000, "获取列表成功", $activitys);
    }

    public function getActivityByTime()
    {
        $token = $this->request->post("token");
        if (!trim($token)) {
            return eShow($this->message->eUserIsToken);
        }
        $user_id = $this->userRepositories->checkToken($token);
        if (!trim($user_id)) {
            return eShow($this->message->eUserIsToken);
        }
        $user = $this->userRepositories->getUserById($user_id);

    }

    public function addUserBrowse()
    {//添加到用户浏览
        $token = $this->request->post("token");
        $activity_id = $this->request->post("activity_id");
        if (!trim($token)) {
            return eShow($this->message->eUserIsToken);
        }
        $user_id = $this->userRepositories->checkToken($token);
        if (!trim($user_id)) {
            return eShow($this->message->eUserIsToken);
        }
        $data = array(
            'user_id' => $user_id,
            'activity_id' => $activity_id,
            'add_time' => time()
        );
        if ($this->activityRepositories->getUserBrowseByUserIdAndActivityid($user_id, $activity_id)) {
            return eShow($this->message->eUserIsAdd);
        }

        if (!$this->activityRepositories->addActivity($data)) {
            return eShow($this->message->eAddError);
        }

        return show(20000, "添加到用户浏览成功");
    }

    public function debugTime()
    {
        $token = $this->request->post("token");
        $tab = $this->request->post("tab");//标签
        $offsetTime = $this->request->post("offsetDay");//起始时间
        $size = $this->request->post('size');//起始条数的天数
        if (!trim($token)) {
            return eShow($this->message->eUserIsToken);
        }
        $user_id = $this->userRepositories->checkToken($token);
        if (!trim($user_id)) {
            return eShow($this->message->eUserIsToken);
        }
        if (!trim($size)) {
            $size = 2;
        }
        $size++;
        $dateList = $this->activityRepositories->getActivityDateList($size, $tab);
        $activityList = [];
        $dateTime = '';
        foreach ($dateList as $key => $value) {//遍历时间组
            $time = strtotime($value->start_time);
            if ($time < $offsetTime && $size != 0) {
//                $date = array(
//                    'weekday' => weekday($time),
//                    'date_time' => date("m/d", $time),
//                );
                $res = $this->activityRepositories->getActivityListByDate($value->start_time, $tab);
                foreach ($res as $key => $val) {
                    if ($val->user_id == $user_id) {
                        $res[$key]->is_browse = 1;
                    } else {
                        $res[$key]->is_browse = 0;
                    }
                    unset($res[$key]->user_id);
                }
                --$size;
                $activityList[$time][] = $res;
            }
        }
        return show(20000, "获取成功", $activityList);
    }
}
