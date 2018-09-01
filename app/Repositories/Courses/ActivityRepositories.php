<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/20
 * Time: 下午 06:59
 */

namespace App\Repositories\Courses;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ActivityRepositories extends BaseRepository
{
    protected $db = 'activity';
    private $pageNumber = 8;

    public function __construct()
    {

    }

    public function getActivityList($page = '', $userNameKey = '')
    {//根据分页获取固定范围的
        if ($page == 'all') {
            return Db::table($this->db)->select()->orderByDesc('add_time')->get();
        }
        if (trim($userNameKey)) {
            return Db::table($this->db)->select()->where('activity_name', 'like', '%' . $userNameKey . '%')->orderByDesc('add_time')->get();
        }
        if (!trim($page)) {
            return Db::table($this->db)->select()->offset(0)->limit($this->pageNumber)->orderByDesc('add_time')->get();
        } else {
            return Db::table($this->db)->select()->offset(($page - 1) * $this->pageNumber)->limit($this->pageNumber)->orderByDesc('add_time')->get();
        }
    }

    public function getActivityPage()
    {//获取权限分页数目
        return ceil(Db::table($this->db)->count() / $this->pageNumber);
    }

    public function getActivityNumber()
    {//获取数据所有条数
        return Db::table($this->db)->count();
    }

    public function delActivityById($id)
    {//根据id删除权限所有数据
        return Db::table($this->db)->where('id', $id)->delete();
    }

    public function getActivityByName($title)//根据文章标题获取所有数据
    {
        return Db::table($this->db)->where('activity_name', $title)->first();
    }

    public function getActivityById($id)
    {//根据id获取权限所有数据
        return Db::table($this->db)->where('id', $id)->first();
    }

    public function setActivityById($data, $id)
    {//根据id修改权限所有数据
        return Db::table($this->db)->where('id', $id)->update($data);
    }

    public function addActivity($data)
    {//添加
        return Db::table($this->db)->insertGetId($data);
    }

    public function selectActivityByKey($size, $key)
    {
        return
            Db::table($this->db)
                ->select([
                    "activity_name",
                    "start_time",
                    "end_time",
                    "activity_des",
                    "up_user_name",
                    "activity_name",
                    "activity_name",
                    "phone",
                ])
                ->offset(0)
                ->limit($size)
                ->where("activity_name", "like", "%" . $key . "%")
                ->where("is_pass", 1)
                ->orderBy("add_time")
                ->get();
    }


    public function addUserBrowse($data)
    {
        return Db::table("user_browse")->insert($data);
    }

    public function getUserBrowseByUserIdAndActivityid($userid, $activity_id)
    {
        return Db::table("user_browse")
            ->where(['user_id' => $userid, 'activity_id' => $activity_id])
            ->first();
    }

    public function getActivityByTime()
    {
        return
            Db::table($this->db)
                ->select()
                ->leftJoin("user_browse", "activity.id", "=", "user_browse.activity_id")
                ->orderByDesc("add_time")
                ->get();
    }

    public function getActivityDateList($size, $tab)
    {
        if (!trim($tab)) {
            return $query_send =
                DB::table($this->db)
                    ->select(DB::raw("FROM_UNIXTIME(start_time,'%Y-%m-%d') as start_time"))//分组获取
                    ->orderByDesc("start_time")
                    ->where("is_pass", 1)
                    ->groupBy(DB::raw("FROM_UNIXTIME(start_time,'%Y-%m-%d')"))
                    ->take($size)
                    ->get();
        } else {
            return $query_send =
                DB::table($this->db)
                    ->select(DB::raw("FROM_UNIXTIME(start_time,'%Y-%m-%d') as start_time"))//分组获取
                    ->orderByDesc("start_time")
                    ->where("is_pass", 1)
                    ->groupBy(DB::raw("FROM_UNIXTIME(start_time,'%Y-%m-%d')"))
                    ->take($size)
                    ->where("category_id",$tab)
                    ->get();
        }
    }

    public function getActivityListByDate($date,$tab){
        if (!trim($tab)){
            return DB::select("SELECT `activity`.*, `user_browse`.`user_id` FROM `activity` LEFT JOIN `user_browse` ON `activity`.`id` = user_browse.activity_id WHERE FROM_UNIXTIME(start_time, '%Y-%m-%d') = :time AND `is_pass` = 1",["time"=> $date]);
        }

        if (trim($tab)){
            return DB::select("SELECT `activity`.*, `user_browse`.`user_id` FROM `activity` LEFT JOIN `user_browse` ON `activity`.`id` = user_browse.activity_id WHERE FROM_UNIXTIME(start_time, '%Y-%m-%d') = :time AND `is_pass` = 1 AND `category_id` = :tab",["time"=> $date,"tab"=>$tab]);
        }
    }
}
