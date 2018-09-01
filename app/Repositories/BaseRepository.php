<?php
/**
 * Created by PhpStorm.
 * User: EDZ
 * Date: 2018/7/24
 * Time: 10:45
 */

namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class BaseRepository
{

    protected $db;

    protected $leftjoin = [];

    protected $field = ['*'];

    protected $orderBy = '';

    public function getList($where = [])
    {
        return DB::table($this->db)
            ->select($this->field)
            ->leftjoin($this->leftjoin)
            ->where($where)
            ->paginate(10);
    }

    public function ajaxList($where = [] , $pageStart = 0 ,$page ,$pageSzie)
    {
        return DB::table($this->db)
            ->select($this->field)
            ->leftjoin($this->leftjoin)
            ->where($where)
            ->offset($pageStart)
            ->limit($page*$pageSzie)
            ->get();
    }

    public function findBy($where = [])
    {
        if(count($this->leftjoin)==0)
        {
            return DB::table($this->db)
                ->select($this->field)
                ->where($where)
                ->first();
        }else{
            return DB::table($this->db)
                ->select($this->field)
                ->leftjoin($this->leftjoin)
                ->where($where)
                ->first();
        }

    }

    public function add($data)
    {
        return DB::table($this->db)->insertGetId($data);
    }

    public function edit($where,$editData)
    {
        return DB::table($this->db)->where($where)->update($editData);
    }

    public function del($where)
    {
        return DB::table($this->db)->where($where)->delete();
    }

    public function getCoutNumber(){//获取数据所有条数
        return Db::table($this->db)->count();
    }
}
