<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/07/28
 * Time: 上午 11:59
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class BrandRepositories extends BaseRepository
{
    protected $db = 'brand';
    private $_db='';
    private  $pageNumber=8;

    public function __construct()
    {
        $this->_db = DB::table($this->db);
    }

    public function getBrandList($page='',$userNameKey=''){//根据分页获取固定范围的
        if ($page=='all'){
            return $this->_db->select()->get();
        }
        if (trim($userNameKey)){
            return $this->_db->where('brand_name',$userNameKey)->get();
        }
        if (!trim($page))
        {
            return $this->_db->offset(0)->limit($this->pageNumber)->get();
        }else{
            return $this->_db->offset(($page-1)*$this->pageNumber)->limit($this->pageNumber)->get();
        }
    }

    public function delBrandById($id){//根据id删除权限所有数据
        return $this->_db->where('id',$id)->delete();
    }
    public function getBrandByName($title)//根据文章标题获取所有数据
    {
        return $this->_db->where('brand_name', $title)->first();
    }

    public function getBrandById($id){//根据id获取权限所有数据
        return $this->_db->where('id',$id)->first();
    }

    public function  setBrandById($id,$data){//根据id修改权限所有数据
        return $this->_db->where('id',$id)->update($data);
    }

    public function addBrand($data){//添加
        return $this->_db->insert($data);
    }
}
