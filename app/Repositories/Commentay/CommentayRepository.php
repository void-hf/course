<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/30
 * Time: 上午 09:47
 */

namespace App\Repositories\Commentay;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class CommentayRepository extends BaseRepository
{
    protected $db = 'comment';
    protected $c_db = 'com_comment';
    private $_db='';
    private  $pageNumber=8;

    public function __construct()
    {
        $this->_db = DB::table($this->db);
    }

    public function getCommentayList($page='',$userNameKey=''){//根据分页获取固定范围的
        if ($page=='all'){
            return $this->_db->select()->get();
        }

        if (trim($userNameKey)){
            return $this->_db->where('user_id',$userNameKey)->get();
        }

        if (!trim($page))
        {
            return $this->_db->offset(0)->limit($this->pageNumber)->get();
        }else{
            return $this->_db->offset(($page-1)*$this->pageNumber)->limit($this->pageNumber)->get();
        }
    }

    public function delCommentayById($id){//根据id删除权限所有数据
        return $this->_db->where('id',$id)->delete();
    }
    public function getCommentayByName($title)//根据文章标题获取所有数据
    {
        return $this->_db->where('brand_name', $title)->first();
    }

    public function getCommentayById($id){//根据id获取权限所有数据
        return $this->_db->where('id',$id)->first();
    }

    public function  setCommentayById($id,$data){//根据id修改权限所有数据
        return $this->_db->where('id',$id)->update($data);
    }

    public function addCommentay($data){//添加
        return $this->_db->insert($data);
    }

    public function getCommentays($offset,$size,$page,$activity_id){
        return $this->_db
                ->offset($offset+($page-1)*$size)
                ->where('activity_id',$activity_id)
                ->limit($size)
                ->orderByDesc("add_time")
                ->get();
    }

    public function getReplyListByCommentayId($commentay){
        return DB::table($this->db)
            ->select()
            ->where('comment_id',$commentay)
            ->orderByDesc("add_time")
            ->get();
    }

}
