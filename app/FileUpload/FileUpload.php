<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/20
 * Time: 下午 03:58
 */

namespace App\FileUpload;
use Illuminate\Support\Facades\Storage;
class FileUpload
{
    private $storage;
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function uploadImgFile($fileClass,$pathUpload)
    {
        $uploadPath = 'upload/'.$pathUpload;//相对路径
        $file = $fileClass;
        // 获取文件路径
        $transverse_pic = $file->getRealPath();
        // public路径
        $path = public_path($uploadPath);
        // 获取后缀名
        $postfix = $file->getClientOriginalExtension();
        // 拼装文件名
        $fileName = md5(time() . rand(0, 10000)) . '.' . $postfix;
        // 移动
        if (!$file->move($path, $fileName)) {
            return false;
        }
        // 这里处理 数据库逻辑
        $data = array(
            'src' => '/'.$uploadPath.'/'.$fileName,
            'title' => $fileName,
        );
        return $data;
    }

    public function uploadFile($fileClass,$pathUpload)
    {
        $uploadPath = 'upload/'.$pathUpload;//相对路径
        $file = $fileClass;
        // 获取文件路径
        $transverse_pic = $file->getRealPath();
        // public路径
        $path = public_path($uploadPath);
        // 获取后缀名
        $postfix = $file->getClientOriginalExtension();

        $fileTitle = $file->getClientOriginalName();
        // 拼装文件名
        $fileName = md5(time() . rand(0, 10000)) . '.' . $postfix;
        // 移动
        if (!$file->move($path, $fileName)) {
            return false;
        }
        // 这里处理 数据库逻辑
        $data = array(
            'src' => '/'.$uploadPath.'/'.$fileName,
            'title' => $fileTitle,
        );
        // 这里处理 数据库逻辑

        return $data;
    }
}
