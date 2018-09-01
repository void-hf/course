<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/07/28
 * Time: 上午 11:59
 */

namespace App\Repositories\Courses;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class CategoryRepositories extends BaseRepository
{
    protected $db = 'category';
    private $pageNumber = 8;

    public function __construct()
    {

    }

    public function getCategoryList($page = '', $userNameKey = '')
    {//根据分页获取固定范围的
        if ($page == 'all') {
            return Db::table($this->db)->select()->orderByDesc('sort_val')->get();
        }
        if (trim($userNameKey)) {
            return Db::table($this->db)->select()->where('category_name', 'like', '%' . $userNameKey . '%')->orderByDesc('sort_val')->get();
        }
        if (!trim($page)) {
            return Db::table($this->db)->select()->offset(0)->limit($this->pageNumber)->orderByDesc('sort_val')->get();
        } else {
            return Db::table($this->db)->select()->offset(($page - 1) * $this->pageNumber)->limit($this->pageNumber)->orderByDesc('sort_val')->get();
        }
    }

    public function getCategoryPage()
    {//获取权限分页数目
        return ceil(Db::table($this->db)->count() / $this->pageNumber);
    }

    public function getCategoryNumber()
    {//获取数据所有条数
        return Db::table($this->db)->count();
    }

    public function delCategoryById($id)
    {//根据id删除权限所有数据
        return Db::table($this->db)->where('id', $id)->delete();
    }

    public function getCategoryByName($title)//根据文章标题获取所有数据
    {
        return Db::table($this->db)->where('category_name', $title)->first();
    }

    public function getCategoryById($id)
    {//根据id获取权限所有数据
        return Db::table($this->db)->where('id', $id)->first();
    }

    public function setCategoryById($id, $data)
    {//根据id修改权限所有数据
        return Db::table($this->db)->where('id', $id)->update($data);
    }

    public function addCategory($data)
    {//添加
        return Db::table($this->db)->insert($data);
    }
}
