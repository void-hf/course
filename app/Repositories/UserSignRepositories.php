<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/09
 * Time: 上午 10:11
 */

namespace App\Repositories;
use Illuminate\Support\Facades\DB;

class UserSignRepositories extends BaseRepository
{
    protected $db = 'user_sign_goods';
    private $_db='';
    private  $pageNumber=8;

    public function __construct()
    {
        $this->_db = DB::table($this->db);
    }

    public function getUserSignGoodsListByUserId($userid,$company,$category_id){
        return $this->_db->select(
            'user_sign_goods.*',
            'goods_parametric.*',
            'goods.*'
        )
            ->leftJoin("goods_parametric","user_sign_goods.goods_id","=","goods_parametric.goods_id")
            ->where(['user_sign_goods.user_id'=>$userid])
            ->leftJoin("goods","user_sign_goods.goods_id","=","goods.id")
            ->where(['company_id'=>$company,'category_id'=>$category_id])
            ->get();
    }

    public function getUserSignGoodsByUserIdAndGoodsId($userid,$goodsid){
        return DB::table($this->db)->where(['user_id'=>$userid,'goods_id'=>$goodsid])->first();
    }

    public function addUserSignGoods($data){
        return $this->_db->insert($data);
    }
    public function delUserSignGoods($userid,$gooid){
        return $this->_db->where(['goods_id'=>$gooid,'user_id'=>$userid])->delete();
    }
}
