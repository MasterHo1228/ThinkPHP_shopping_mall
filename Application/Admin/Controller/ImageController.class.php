<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/9
 * Time: 16:39
 */

namespace Admin\Controller;

use Think\Controller;

/**
 * 图片上传控制类
 * Class ImageController
 * @package Admin\Controller
 */
class ImageController extends Controller
{
    /**
     * 上传商品图片方法(配合前端上传裁剪图片插件使用)
     */
    public function uploadHeaderImg()
    {
        //清除上次上传的图片的url
        session('uploadHeaderImgUrl', null);
        if (checkSalesUserLogin()) {
            $model = new \Admin\Model\ImageModel();
            $info = $model->upload('header/');
            if ($info) {
                $avatarArr = json_decode(I('post.avatar_data', '', ''), true);
                $filePath = './Public/uploads/header/';
                $fileName = $info['avatar_file']['savename'];
                if ($model->cropImage($avatarArr, $filePath, $fileName)) {
                    //用session暂存图片的路径，稍后添加商品的时候一并写入数据库
                    $url = DEFAULT_HEADER_PIC_PATH . $info['avatar_file']['savename'];
                    //AJAX返回上传处理后的图片url
                    $data['result'] = $url;
                    session('uploadHeaderImgUrl', $url);
                } else {
                    $data['error'] = 'Crop image failed!';
                }
            } else {
                $data['error'] = $info;
            }
            $this->ajaxReturn($data);
        }
    }

    /**
     * 上传图片方法(配合wangEditor富文本编辑器使用)
     */
    public function uploadImg()
    {
        if (checkSalesUserLogin()) {
            $model = new \Admin\Model\ImageModel();
            $info = $model->upload('', true);
            if ($info) {
                $urlPrefix = URL . UPLOAD_PATH;
                foreach ($info as $file) {
                    $url = $urlPrefix . $file['savepath'] . $file['savename'];
                    $this->ajaxReturn($url, 'EVAL');
                }
            } else {
                $this->ajaxReturn('error|' . $info, 'EVAL');
            }
        }
    }
}