<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/28
 * Time: 上午 09:55
 */

namespace App\Repositories\Travel;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class TravelRepository extends BaseRepository
{
    protected $db = "user_travel";
    private $pageNumber = 8;

    public function getPageNum()
    {//获取权限分页数目
        return ceil(Db::table($this->db)->count() / $this->pageNumber);
    }

    public function getTravelList($page = '', $userNameKey = '')
    {//根据分页获取固定范围的用户
        if ($page == 'all') {
            return Db::table($this->db)->select()->get();
        }

        if (trim($userNameKey)) {
            return Db::table($this->db)->select(
                'user_travel.*',
                'users.user_name',
                'users.user_head_img',
                'activity.activity_name'
            )
                ->where('user_name', "like", "%" . $userNameKey . "%")
                ->leftJoin("users", "user_travel.user_id", "=", "users.id")
                ->leftJoin("activity", "user_travel.activity_id", "=", "activity.id")
                ->get();
        }
        if (!trim($page)) {
            return Db::table($this->db)->select(
                'user_travel.*',
                'users.user_name',
                'users.user_head_img',
                'activity.activity_name'
            )
                ->leftJoin("users", "user_travel.user_id", "=", "users.id")
                ->leftJoin("activity", "user_travel.activity_id", "=", "activity.id")
                ->offset(0)
                ->limit($this->pageNumber)
                ->get();
        } else {
            return Db::table($this->db)->select(
                'travel.*',
                'users.user_name',
                'users.user_head_img',
                'activity.activity_name'
            )
                ->where('user_name', "like", "%" . $userNameKey . "%")
                ->leftJoin("users", "user_travel.user_id", "=", "users.id")
                ->leftJoin("activity", "user_travel.activity_id", "=", "activity.id")
                ->offset(($page - 1) * $this->pageNumber)
                ->limit($this->pageNumber)
                ->get();
        }
    }


    public function getTravelById($id)
    {
        return Db::table($this->db)->select(
            'user_travel.*',
            'users.user_name',
            'users.user_head_img',
            'activity.activity_name',
            'activity.activity_address',
            'activity.id',
            'activity.up_user_name'

        )
            ->where('user_travel.id', $id)
            ->leftJoin("users", "user_travel.user_id", "=", "users.id")
            ->leftJoin("activity", "user_travel.activity_id", "=", "activity.id")
            ->first();
    }
}
