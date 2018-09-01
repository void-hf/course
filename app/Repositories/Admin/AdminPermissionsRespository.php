<?php
/**
 * Created by PhpStorm.
 * User: EDZ
 * Date: 2018/7/24
 * Time: 11:13
 */

namespace App\Repositories\Admin;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class AdminPermissionsRespository extends BaseRepository
{
    protected $db = 'admin_permissions';
    private  $_db='';
    private  $pageNumber=8;

    public function __construct()
    {
        $this->_db = Db::table($this->db);
    }

    public function getPermissionsList($page='',$userNameKey=''){//根据分页获取固定范围的用户
        if ($page=='all'){
            return $this->_db->select()->get();
        }
        if (trim($userNameKey)){
            return $this->_db->where('names',$userNameKey)->get();
        }
        if (!trim($page))
        {
            return $this->_db->offset(0)->limit($this->pageNumber)->get();
        }else{
            return $this->_db->offset(($page-1)*$this->pageNumber)->limit($this->pageNumber)->get();
        }
    }

    public function getPermissionsPage(){//获取权限分页数目
        return ceil(Db::table($this->db)->count()/$this->pageNumber);
    }

    public function getPermissionsNumber()
    {
        return Db::table($this->db)->count();
    }
    public function delPermissionsById($id){//根据id删除权限所有数据
        return $this->_db->where('id',$id)->delete();
    }

    public function getPermissionsById($id){//根据id获取权限所有数据
        return $this->_db->where('id',$id)->first();
    }

    public function  setPermissionsById($id,$data){//根据id修改权限所有数据
        return $this->_db->where('id',$id)->update($data);
    }

    public function addPermissions($data){//添加用户
        return $this->_db->insert($data);
    }
}
