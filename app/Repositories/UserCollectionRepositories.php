<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/01
 * Time: 下午 01:52
 */

namespace App\Repositories;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\DB;


class UserCollectionRepositories extends Repository
{
    protected $db = 'user_collection';
    private $_db='';
    private  $pageNumber=8;
    public function __construct()
    {
        $this->_db = DB::table($this->db);
    }
    public function getUserCollectionListBy(){//根据分页获取固定范围的
            return $this->_db->select()->get();
    }
    public function getUserCollectionParametricListByCompanyAndCategoryId($companyid,$categoryid,$userid){
        if (!trim($companyid)||!trim($categoryid)){
            return $this->_db->select(
                'user_collection.*',
                'goods.*',
                'goods_parametric.*'
            )
                ->where(['userid'=>$userid,'user_id'=>0])
                ->leftJoin("goods","user_collection.goods_id","=","goods.id")
                ->leftJoin("goods_parametric","goods.id","=","goods_parametric.goods_id")
                ->get();
        }
        return $this->_db->select(
            'user_collection.*',
            'goods.*',
            'goods_parametric.*'
        )
            ->where('userid','=',$userid)
            ->leftJoin("goods","user_collection.goods_id","=","goods.id")
            ->leftJoin("goods_parametric","goods.id","=","goods_parametric.goods_id")
            ->where(['company_id'=>$companyid,'category_id'=>$categoryid])
            ->get();
    }
    public function getUserCollectionPage(){//获取权限分页数目
        return ceil(Db::table($this->db)->count()/$this->pageNumber);
    }
    public function getUserCollectionNumber(){//获取数据所有条数
        return Db::table($this->db)->count();
    }
    public function delUserCollectionById($id){//根据id删除权限所有数据
        return $this->_db->where('id',$id)->delete();
    }
    public function getUserCollectionByGoodsId($userid,$id){//根据id删除权限所有数据
        return DB::table($this->db)->where(['userid'=>$userid,'goods_id'=>$id])->first();
    }

    public function delUserCollectionByUserIdAndGoodsId($user_id,$goods_id){
        return $this->_db->where(['goods_id'=>$goods_id,"userid"=>$user_id])->delete();
    }

    public function getUserCollectionByUserId($UserId,$goods_id)//根据文章标题获取所有数据
    {
        return $this->_db->where(['userid'=> $UserId,'goods_id'=>$goods_id])->first();
    }
    public function getUserCollectionById($id){//根据id获取权限所有数据
        return $this->_db->where('id',$id)->first();
    }
    public function  setUserCollectionById($id,$data){//根据id修改权限所有数据
        return $this->_db->where('id',$id)->update($data);
    }
    public function addUserCollection($data){//添加
        return $this->_db->insert($data);
    }
    public function getUserCollectionCompanylist($userId){
        return DB::table($this->db)->select(
            'goods.company_id',
            'design_company.company_name'
        )
            ->distinct('goods.company_id')
            ->leftJoin("goods","user_collection.goods_id","=","goods.id")
            ->leftJoin("design_company","goods.company_id","=","design_company.id")
            ->where('userid',$userId)
            ->get();
    }
    public function getUserCollectionCategorylist($userId,$companyid){
        return DB::table($this->db)->select(
            'category.id',
            'category.category_name'
        )
            ->distinct("category.id")
            ->leftJoin("goods","user_collection.goods_id","=","goods.id")
            ->leftJoin("category","goods.category_id","=","category.id")
            ->where(['user_collection.userid'=>$userId,'goods.company_id'=>$companyid])
            ->get();
    }
}
