<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/07/28
 * Time: 上午 11:59
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis; //引入redis
use App\Service\RedisService;
class UserRepositories extends BaseRepository
{
    protected $db = 'users';
    private $_db='';
    private $redisService;
    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
        $this->_db = DB::table($this->db);
    }

    public function getUserList($where){
        if (!trim($where)){
            return Db::table($this->db)->select()->get();
        }
        return Db::table($this->db)->select()->where($where)->get();
    }

    public function getUserNumber(){//获取数据所有条数
        return Db::table($this->db)->count();
    }
    public function delUserById($id){//根据id删除权限所有数据
        return $this->_db->where('id',$id)->delete();
    }

    public function getUserListCout(){//获取所有用户的数目
        return DB::table($this->db)->count();
    }

    public function getUserByOpenId($openid)
    {
        return $this->_db->where('openid', $openid)->first();
    }
    public function getUserById($id){//根据id获取权限所有数据
        return $this->_db->where('id',$id)->first();
    }
    public function setUserById($id,$data){//根据id修改权限所有数据
        return $this->_db->where('id',$id)->update($data);
    }
    public function addUser($data){//添加用户
        return $this->_db->insert($data);
    }
    public function addUserGetId($data){//添加用户
        return $this->_db->insertGetId($data);
    }
    public function addUserToken($data){
        return Db::table('user_token')->insert();
    }
    public function getUserByToken($token){
        return $this->_db->select(
            'user.*',
            'user_token.token'
        )
            ->leftJoin("user_token","user.id","=","user_token.user_id")
            ->where('user_token.token',$token)
            ->get();
    }

    public function updataTokenByUserId($userid,$data){
        return $this->_db->where('user_id',$userid)->update($data);
    }
    public function delUserToken($user_token){
      //  return Db::table('user_token')->where()->
    }

    public function updateUserToken($user,$data){
        return Db::table('user_token')->where('user_id')->update($data);
    }

    public function checkToken($toekn){
        if ($user_id = $this->redisService->findBy($toekn)){
            return $user_id;
        }else{
            return false;
        }
    }
}
