<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016/12/10
 * Time: 19:46
 */

namespace Admin\Model;

/**
 * 图片处理独立模型类
 * Class ImageModel
 * @package Admin\Model
 * @author MasterHo1228
 */
class ImageModel
{
    /**
     * 上传图片
     * @param string $folder 上传图片子路径，默认为空
     * @param bool $autoSub 是否自动创建以日期命名的子目录，默认为false
     * @return array|bool|string
     */
    public function upload($folder = '', $autoSub = false)
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = '.' . UPLOAD_PATH . $folder . '/'; // 设置附件上传根目录
        $upload->autoSub = $autoSub; // 设置自动使用子目录保存上传文件
        // 上传文件
        $info = $upload->upload();

        if (!$info) {// 上传错误
            //返回错误信息
            return $upload->getError();
        } else {
            //返回信息数组
            return $info;
        }
    }

    /**
     * 裁剪图片
     * @param array $cropData 裁剪图片参数数据
     * @param string $filePath 文件目录
     * @param string $fileName 文件名
     * @return bool
     */
    public function cropImage($cropData, $filePath, $fileName)
    {
        if (!empty($cropData) && !empty($filePath) && !empty($fileName)) {
            $image = new \Think\Image();
            //打开图片
            $imgUrl = $filePath . $fileName;
            $image->open($imgUrl);
            //剪裁图片并覆盖保存
            return $image->crop($cropData['width'], $cropData['height'], $cropData['x'], $cropData['y'])->save($imgUrl);
        } else {
            return false;
        }
    }

}