<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/10
 * Time: 上午 09:19
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
class UserTokenRepositories extends BaseRepository
{
    protected $db = 'user_token';
    private $_db='';
    private  $pageNumber=8;
    public function __construct()
    {
        $this->_db= Db::table($this->db);
    }

    public function getUserByToken($token){
        return $this->_db->select(
            'user_token.*',
            'users.nickname',
            'users.headimg',
            'users.phone',
            'users.openid'
        )
            ->leftJoin("users","user_token.user_id","=","users.id")
            ->where(["token"=>$token])
            ->first();
    }

    public function getUserTokenByUserId($user_id){
        return $this->_db->where("user_id",$user_id)->first();
    }

    public function delUserTokenByUserId($user_id){
        return $this->_db->where("user_id",$user_id)->delete();
    }

    public function delUserTokenByToken($token){
        return $this->_db->where("token",$token)->delete();
    }

    public function addUserToken($data){
        return $this->_db->insert($data);
    }

    public function updataUserTokenByUserId($user,$data){
        return $this->_db->where("user_id",$user)->update($data);
    }
}
