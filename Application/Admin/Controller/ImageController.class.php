<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/9
 * Time: 16:39
 */

namespace Admin\Controller;

use Think\Controller;

class ImageController extends Controller
{
    public function uploadHeaderImg()
    {
        //清除上次上传的图片的url
        session('uploadHeaderImgUrl', null);
        if (session('?salesUID')) {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = '.' . UPLOAD_PATH . 'header/'; // 设置附件上传根目录
            $upload->autoSub = false; // 设置自动使用子目录保存上传文件
            // 上传文件
            $info = $upload->upload();
            if (!$info) {// 上传错误提示错误信息
                $data['error'] = $upload->getError();
            } else {// 上传成功
                $avatarData = $_POST['avatar_data'];
                $avatarArr = json_decode($avatarData,true);
                //截图略缩图
                $image = new \Think\Image();
                $imgPath = './Public/uploads/header/'.$info['avatar_file']['savename'];
                $image->open($imgPath);
                $image->crop($avatarArr['width'], $avatarArr['height'],$avatarArr['x'],$avatarArr['y'])->save($imgPath);

                //用session暂存图片的路径，稍后添加商品的时候一并写入数据库
                $url = DEFAULT_HEADER_PIC_PATH.$info['avatar_file']['savename'];
                $data['result'] = $url;
                session('uploadHeaderImgUrl', $url);
            }
            $this->ajaxReturn($data);
        }
    }

    public function uploadImg()
    {
        if (session('?salesUID')) {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = '.' . UPLOAD_PATH; // 设置附件上传根目录

            //上传图片的路径
            $urlPrefix = URL . UPLOAD_PATH;
            // 上传单个文件
            $info = $upload->upload();
            if (!$info) {// 上传错误提示错误信息
                $this->ajaxReturn('error|' . $upload->getError(), 'EVAL');
            } else {// 上传成功 获取上传文件信息
                foreach ($info as $file) {
                    $url = $urlPrefix . $file['savepath'] . $file['savename'];
                    $this->ajaxReturn($url, 'EVAL');
                }
            }
        }
    }
}