<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/6
 * Time: 15:11
 */

namespace Admin\Controller;

use Think\Controller;

class GoodsController extends Controller
{
    public function getList()
    {
        if (session('?salesUID')) {
            $model = M('viewgoodsdetail');
            $this->ajaxReturn($model->field('gID,gName,goodsTypeName,gPrice,gOriginPrice,gCount,gSalesSUID,shopName,gPubTime,gStatus')->select());
        } else if (session('?salesUID')) {
            $salesUID = session('salesUID');
            $model = M('viewgoodsdetail');
            $this->ajaxReturn($model->where('gSalesSUID=' . $salesUID)->field('gID,gName,goodsTypeName,gPrice,gOriginPrice,gCount,gSalesSUID,shopName,gPubTime,gStatus')->select());
        }
    }

    public function getCurrentInfo()
    {
        if (IS_GET && session('?salesUID')) {
            $goodsID = I('get.goodsID/d');
            $model = M('viewgoodsdetail');

            $this->ajaxReturn($model->where('gID=' . $goodsID)->field('gID,gName,gType,goodsTypeName,gPrice,gOriginPrice,gCount,gSalesSUID,shopName,gPhoto,gDescription,gPubTime,gStatus')->find());
        }
    }

    public function getTypeList()
    {
        if (session('?salesUID')) {
            $table = M('goodstype');
            $this->ajaxReturn($table->field('tID,tName')->select());
        }
    }

    public function uploadHeaderImg()
    {
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
                //上传图片的路径
                foreach ($info as $file) {
                    $url = DEFAULT_HEADER_PIC_PATH . $file['savename'];
                    $data['url'] = $url;
                    session('uploadHeaderImgUrl', $url);
                }
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

    public function add()
    {
        $goodsHeaderPic = session('uploadHeaderImgUrl');
        if (IS_POST && session('?salesUID')) {

            $goodsName = I('post.goodsName/s');
            $goodsType = I('post.goodsType/d');
            $goodsPrice = I('post.goodsPrice/f');
            $goodsOriginPrice = I('post.goodsOriginPrice/f');
            $goodsCount = I('post.goodsCount/d');
            $goodsDesc = I('post.goodsDesc/s', '', 'htmlspecialchars,nl2br');

            $model = D('goods');
            if ($model->addNewGoods($goodsName, $goodsType, $goodsPrice, $goodsOriginPrice, $goodsCount, $goodsDesc, $goodsHeaderPic)) {
                $this->success('商品添加成功！', U('Admin/Iframe/goods_list'));
            } else {
                $this->error('商品添加失败！');
            }
        } else {
            $this->error('非法操作！！', U('Admin/Index/login'));
        }
    }

    public function update()
    {
        if (IS_POST && session('?salesUID')) {
            $goodsID = I('post.goodsID/d');
            $goodsName = I('post.goodsName/s');
            $goodsType = I('post.goodsType/d');
            $goodsPrice = I('post.goodsPrice/f');
            $goodsOriginPrice = I('post.goodsOriginPrice/f');
            $goodsCount = I('post.goodsCount/d');
            $goodsDesc = I('post.goodsDesc/s', '', 'htmlspecialchars,nl2br');

            $model = D('goods');
            if ($model->updateGoods($goodsID, $goodsName, $goodsType, $goodsPrice, $goodsOriginPrice, $goodsCount, $goodsDesc)) {
                $this->success('商品信息更新成功！', U('Admin/Iframe/goods_list'));
            } else {
                $this->error('商品信息更新失败！');
            }
        }
    }

    public function delete()
    {
        if (IS_POST && IS_AJAX && session('?salesUID')) {
            $goodsID = I('post.goodsID/d');
            $model = D('goods');

            if ($model->deleteGoods($goodsID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    public function shutdown()
    {
        if (IS_POST && IS_AJAX && session('?salesUID')) {
            $goodsID = I('post.goodsID/d');
            $model = D('goods');

            if ($model->shutdownGoods($goodsID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    public function goodsReturn()
    {
        if (IS_POST && IS_AJAX && session('?salesUID')) {
            $goodsID = I('post.goodsID/d');
            $model = D('goods');

            if ($model->returnGoods($goodsID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    public function rankTop()
    {
        if (IS_POST && IS_AJAX && session('?salesUID')) {
            $goodsID = I('post.goodsID/d');
            $model = D('goods');

            if ($model->goodsRankTop($goodsID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    public function rankDown()
    {
        if (IS_POST && IS_AJAX && session('?salesUID')) {
            $goodsID = I('post.goodsID/d');
            $model = D('goods');

            if ($model->goodsRankDown($goodsID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }
}