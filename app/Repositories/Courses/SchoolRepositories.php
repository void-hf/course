<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/20
 * Time: 下午 05:38
 */

namespace App\Repositories\Courses;

use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;

class SchoolRepositories extends BaseRepository
{
    protected $db = 'school';
    private $pageNumber = 8;

    public function __construct()
    {
    }

    public function getSchoolList($page = '', $userNameKey = '')
    {//根据分页获取固定范围的
        if ($page == 'all') {
            return Db::table($this->db)->select()->get();
        }
        if (trim($userNameKey)) {
            return Db::table($this->db)->select()->where('school_name', 'like', '%' . $userNameKey . '%')->get();
        }
        if (!trim($page)) {
            return Db::table($this->db)->select()->offset(0)->limit($this->pageNumber)->get();
        } else {
            return Db::table($this->db)->select()->offset(($page - 1) * $this->pageNumber)->limit($this->pageNumber)->get();
        }
    }

    public function getSchoolPage()
    {//获取权限分页数目
        return ceil(Db::table($this->db)->count() / $this->pageNumber);
    }

    public function getSchoolNumber()
    {//获取数据所有条数
        return Db::table($this->db)->count();
    }

    public function delSchoolById($id)
    {//根据id删除权限所有数据
        return Db::table($this->db)->where('id', $id)->delete();
    }

    public function getSchoolByName($title)//根据文章标题获取所有数据
    {
        return Db::table($this->db)->where('school_name', $title)->first();
    }

    public function getSchoolById($id)
    {//根据id获取权限所有数据
        return Db::table($this->db)->where('id', $id)->first();
    }

    public function setSchoolById($id, $data)
    {//根据id修改权限所有数据
        return Db::table($this->db)->where('id', $id)->update($data);
    }

    public function addSchool($data)
    {//添加
        return Db::table($this->db)->insert($data);
    }
}
