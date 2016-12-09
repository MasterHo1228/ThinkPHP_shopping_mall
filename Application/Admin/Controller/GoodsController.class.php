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

    public function add()
    {
        if (IS_POST && session('?salesUID')) {

            $goodsName = I('post.goodsName/s');
            $goodsType = I('post.goodsType/d');
            $goodsPrice = I('post.goodsPrice/f');
            $goodsOriginPrice = I('post.goodsOriginPrice/f');
            $goodsCount = I('post.goodsCount/d');
            $goodsDesc = I('post.goodsDesc/s', '', 'htmlspecialchars,nl2br');
            $goodsHeaderPic = session('uploadHeaderImgUrl');

            $model = D('goods');
            if ($model->addNewGoods($goodsName, $goodsType, $goodsPrice, $goodsOriginPrice, $goodsCount, $goodsDesc, $goodsHeaderPic)) {
                session('uploadHeaderImgUrl', null);
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