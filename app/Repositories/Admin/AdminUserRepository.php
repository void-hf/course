<?php
/**
 * Created by PhpStorm.
 * User: EDZ
 * Date: 2018/7/24
 * Time: 11:07
 */

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class AdminUserRepository extends BaseRepository
{
    protected $db = 'admin_user';
    private $_db = '';
    private $pageNumber = 8;

    public function __construct()
    {
        $this->_db = Db::table($this->db);
    }

    public function getUserList($page = '', $userNameKey = '')
    {//根据分页获取固定范围的用户
        if ($page=='all'){
            return $this->_db->select()->get();
        }
        if (trim($userNameKey)) {
            return $this->_db->where('username','like','%'.$userNameKey.'%')->get();
        }

        if (!trim($page)) {
            return $this->_db->offset(0)->limit($this->pageNumber)->get();
        } else {
            return $this->_db->offset(($page - 1) * $this->pageNumber)->limit($this->pageNumber)->get();
        }
    }

    public function getUserPage()
    {//获取所有分页数目
        return ceil(Db::table($this->db)->count() / $this->pageNumber);
    }

    public function getUserNumber()
    {
        return Db::table($this->db)->count();
    }

    public function delUserById($id)
    {//根据id删除用户所有数据
        return $this->_db->where('id', $id)->delete();
    }

    public function getUserById($id)
    {//根据id获取用户所有数据
        return $this->_db->where('id', $id)->first();
    }

    public function getUserByName($name)
    {//根据id获取用户所有数据
        return $this->_db->where('username', $name)->first();
    }

    public function setUserById($id, $data)
    {//根据id修改用户所有数据
        return $this->_db->where('id', $id)->update($data);
    }

    public function addUser($data)
    {//添加用户
        return $this->_db->insert($data);
    }
}
