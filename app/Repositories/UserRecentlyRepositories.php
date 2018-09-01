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


class UserRecentlyRepositories extends Repository
{
    protected $db = 'user_recently';
    private $_db='';
    private  $pageNumber=8;

    public function __construct()
    {
        $this->_db = DB::table($this->db);
    }

    public function getUserCollectionListBy(){//根据分页获取固定范围的
        return $this->_db->select()->get();
    }

    public function getUserRecentlyListByCompanyAndCategoryId($companyid,$categoryid,$user_id,$ltime){
        return $this->_db->select(
            'user_recently.*',
            'goods.*',
            'goods_parametric.*'
        )
            ->where('addtime','>',strtotime($ltime." days"))
            ->where('userid','=',$user_id)
            ->leftJoin("goods","user_recently.goods_id","=","goods.id")
            ->leftJoin("goods_parametric","goods.id","=","goods_parametric.goods_id")
            ->where(['company_id'=>$companyid,'category_id'=>$categoryid])
            ->get();
    }

    public function getUserRecentlyPage(){//获取权限分页数目
        return ceil(Db::table($this->db)->count()/$this->pageNumber);
    }

    public function getUserRecentlyNumber(){//获取数据所有条数
        return Db::table($this->db)->count();
    }

    public function delUserRecentlyById($id){//根据id删除权限所有数据
        return $this->_db->where('id',$id)->delete();
    }

    public function getUserRecentlyByUserId($UserId,$goods_id)//根据文章标题获取所有数据
    {
        return $this->_db->where(['userid'=> $UserId,'goods_id'=>$goods_id])->first();
    }

    public function getUserRecentlyById($id){//根据id获取权限所有数据
        return $this->_db->where('id',$id)->first();
    }

    public function  setUserRecentlyById($id,$data){//根据id修改权限所有数据
        return $this->_db->where('id',$id)->update($data);
    }

    public function addUserRecently($data){//添加
        return $this->_db->insert($data);
    }

    public function getRecentlyCompanylist($userId,$ltime){//获取用户最近浏览的商品分类
        return DB::table($this->db)->select(
            'goods.company_id',
            'design_company.company_name'
        )
            ->distinct('goods.company_id')
            ->where('addtime','>',strtotime($ltime." days"))
            ->leftJoin("goods","user_recently.goods_id","=","goods.id")
            ->leftJoin("design_company","goods.company_id","=","design_company.id")
            ->where('userid',$userId)
            ->get();
    }

    public function getUserRecentlyCategorylist($userId,$companyid,$ltime){
        return DB::table($this->db)->select(
            'category.id',
            'category.category_name'
        )
            ->distinct("category.id")
            ->where('addtime','>',strtotime($ltime." days"))
            ->leftJoin("goods","user_recently.goods_id","=","goods.id")
            ->leftJoin("category","goods.category_id","=","category.id")
            ->where(['user_recently.userid'=>$userId,'goods.company_id'=>$companyid])
            ->get();
    }
}
