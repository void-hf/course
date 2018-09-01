<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/17
 * Time: 下午 08:31
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class SystemsettingRepositories extends BaseRepository
{
    protected $db = "system_setting";
    protected $imgBanner = "banner_img";
    public function getSystemsetting()
    {
        return Db::table($this->db)->where('settingname', 'systemsetting')->first();
    }

    public function updateSystemsetting($data)
    {
        return Db::table($this->db)->where('settingname', 'systemsetting')->update($data);
    }

    public function addImgBanner($data)
    {
        return DB::table($this->imgBanner)->insert($data);
    }

    public function getImgBannerList()
    {
        return DB::table($this->imgBanner)->get();
    }

    public function delImgBanner()
    {
        return DB::table($this->imgBanner)->delete();
    }
}
