<?php
/**
 * Created by PhpStorm.
 * User: EDZ
 * Date: 2018/7/25
 * Time: 10:53
 */

namespace App\Service;
use GuzzleHttp\Client;

class WxchatService
{
    protected $authorizationUrl = 'https://api.weixin.qq.com/sns/jscode2session';

    protected $authOpenid = 'https://api.weixin.qq.com/sns/jscode2session';

    protected $appid = 'wxe8d0deb187bc5653';

    protected $secret = '870d6f67144636346a22abfd1cad90df';

    protected $noce = "windowsddt";

    // $urls="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";


    public function authorization($code)
    {
        $url = $this->authorizationUrl.'?appid='.$this->appid.'&secret='.$this->secret.'&js_code='.$code.'&grant_type=authorization_code';
        $client = new Client();
        $response = $client->get($url,['verify' => false]);
        if($response->getStatusCode() == 200)
        {
            $data = $response->getBody()->getContents();
            return $data;
        }else{
            return false;
        }
    }

    public function creatToken($string,$time){
        return md5($string.$time.$this->noce);
    }

    public function getOpenId($code){
        $url = $this->authOpenid.'?appid='.$this->appid.'&secret='.$this->secret.'&js_code='.$code.'&grant_type=authorization_code';
        $client = new Client();
        $response = $client->get($url,['verify' => false]);
        if($response->getStatusCode() == 200)
        {
            $data = $response->getBody()->getContents();
            return $data;
        }else{
            return false;
        }
    }

    public function getUserPhone(){

    }
}
