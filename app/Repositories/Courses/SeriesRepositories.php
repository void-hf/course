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

class SeriesRepositories extends BaseRepository
{
    protected $db = 'series';
    private $pageNumber = 8;

    public function __construct()
    {

    }

    public function getSeriesList($page = '', $userNameKey = '')
    {//根据分页获取固定范围的
        if ($page == 'all') {
            return Db::table($this->db)->select()->get();
        }

        if (trim($userNameKey)) {
            return Db::table($this->db)->select()->where('series_name', 'like', '%' . $userNameKey . '%')->get();
        }

        if (!trim($page)) {
            return Db::table($this->db)->select()->offset(0)->limit($this->pageNumber)->get();
        } else {
            return Db::table($this->db)->select()->offset(($page - 1) * $this->pageNumber)->limit($this->pageNumber)->get();
        }
    }

    public function getSeriesPage()
    {//获取权限分页数目
        return ceil(Db::table($this->db)->count() / $this->pageNumber);
    }

    public function getSeriesNumber()
    {//获取数据所有条数
        return Db::table($this->db)->count();
    }

    public function delSeriesById($id)
    {//根据id删除权限所有数据
        return Db::table($this->db)->where('id', $id)->delete();
    }

    public function getSeriesByName($title)//根据文章标题获取所有数据
    {
        return Db::table($this->db)->where('series_name', $title)->first();
    }

    public function getSeriesById($id)
    {//根据id获取权限所有数据
        return Db::table($this->db)->where('id', $id)->first();
    }

    public function setSeriesById($id, $data)
    {//根据id修改权限所有数据
        return Db::table($this->db)->where('id', $id)->update($data);
    }

    public function addSeries($data)
    {//添加
        return Db::table($this->db)->insert($data);
    }
}
