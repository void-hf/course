<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/29
 * Time: 下午 05:26
 */

namespace App\Service;
use Illuminate\Support\Facades\Redis; //引入redis
use Illuminate\Support\Facades\Hash;
class RedisService
{
    private $redis;
    protected $timeOut=36000;
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }
    public function findBy($key){
        return $this->redis::get($key);
    }

    public function setFile($key,$val){
        return $this->redis::setex($key,$this->timeOut,$val);
    }

    public function serGFile($key,$val){
         $this->redis::setex($key,$this->timeOut,$val);
        return $this->redis::setex($val,$this->timeOut,$key);
    }
}
