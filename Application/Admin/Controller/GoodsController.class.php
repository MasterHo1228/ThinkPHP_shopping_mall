<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/6
 * Time: 15:11
 */

namespace Admin\Controller;

use Think\Controller;

/**
 * 商品控制类
 * Class GoodsController
 * @package Admin\Controller
 */
class GoodsController extends Controller
{
    /**
     * 获取商品列表
     * （管理员）获取全部商品列表
     * （商铺账号）获取该店铺的所有商品
     */
    public function getList()
    {
        if (checkAdminLogin()) {
            $model = M('viewgoodsdetail');
            $this->ajaxReturn($model->field('gID,gName,goodsTypeName,gPrice,gOriginPrice,gCount,gSalesSUID,shopName,gPubTime,gStatus')->select());
        } else if (checkSalesUserLogin()) {
            $salesUID = session('salesUID');
            $model = M('viewgoodsdetail');
            $this->ajaxReturn($model->where('gSalesSUID=' . $salesUID)->field('gID,gName,goodsTypeName,gPrice,gOriginPrice,gCount,gSalesSUID,shopName,gPubTime,gStatus')->select());
        }
    }

    /**
     * 查看对应商品的详细信息
     */
    public function getCurrentInfo()
    {
        if (IS_GET && checkSalesUserLogin()) {
            $goodsID = I('get.goodsID/d');
            $model = M('viewgoodsdetail');

            $this->ajaxReturn($model->where('gID=' . $goodsID)->field('gID,gName,gType,goodsTypeName,gPrice,gOriginPrice,gSoldOutNum,gCount,gSalesSUID,shopName,gPhoto,gDescription,gPubTime,gStatus')->find());
        }
    }

    /**
     * 获取商品类型列表
     */
    public function getTypeList()
    {
        if (checkSalesUserLogin()) {
            $table = M('goodstype');
            $this->ajaxReturn($table->field('tID,tName')->select());
        }
    }

    /**
     * 添加商品
     */
    public function add()
    {
        if (IS_POST && checkSalesUserLogin()) {
            $goodsName = I('post.goodsName/s');
            $goodsType = I('post.goodsType/d');
            $goodsPrice = I('post.goodsPrice/f', 0);
            $goodsOriginPrice = I('post.goodsOriginPrice/f', 0);
            $goodsCount = I('post.goodsCount/d', 0);
            $goodsDesc = I('post.goodsDesc/s', '暂无商品描述', 'htmlspecialchars,nl2br');
            $goodsHeaderPic = session('uploadHeaderImgUrl');

            $model = D('goods');
            if ($model->addNewGoods($goodsName, $goodsType, $goodsPrice, $goodsOriginPrice, $goodsCount, $goodsDesc, $goodsHeaderPic)) {
                session('uploadHeaderImgUrl', null);
                $this->success('商品添加成功！', U('backyard/Iframe/goods_list'));
            } else {
                $this->error('商品添加失败！');
            }
        }
    }

    /**
     * 更新商品信息
     */
    public function update()
    {
        if (IS_POST && session('?salesUID')) {
            $goodsID = I('post.goodsID/d');
            $goodsName = I('post.goodsName/s');
            $goodsType = I('post.goodsType/d');
            $goodsPrice = I('post.goodsPrice/f', 0);
            $goodsOriginPrice = I('post.goodsOriginPrice/f', 0);
            $goodsCount = I('post.goodsCount/d', 0);
            $goodsDesc = I('post.goodsDesc/s', '暂无商品描述', 'htmlspecialchars,nl2br');

            $model = D('goods');
            if ($model->updateGoods($goodsID, $goodsName, $goodsType, $goodsPrice, $goodsOriginPrice, $goodsCount, $goodsDesc)) {
                $this->success('商品信息更新成功！', U('backyard/Iframe/goods_list'));
            } else {
                $this->error('商品信息更新失败！');
            }
        }
    }

    /**
     * 删除商品
     */
    public function delete()
    {
        if (IS_POST && IS_AJAX && checkSalesUserLogin()) {
            $goodsID = I('post.goodsID/d');
            $model = D('goods');

            if ($model->deleteGoods($goodsID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    /**
     * 下架商品
     */
    public function shutdown()
    {
        if (IS_POST && IS_AJAX && checkSalesUserLogin()) {
            $goodsID = I('post.goodsID/d');
            $model = D('goods');

            if ($model->shutdownGoods($goodsID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    /**
     * 重上架商品
     */
    public function goodsReturn()
    {
        if (IS_POST && IS_AJAX && checkSalesUserLogin()) {
            $goodsID = I('post.goodsID/d');
            $model = D('goods');

            if ($model->returnGoods($goodsID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    /**
     * 置顶商品
     */
    public function rankTop()
    {
        if (IS_POST && IS_AJAX && checkSalesUserLogin()) {
            $goodsID = I('post.goodsID/d');
            $model = D('goods');

            if ($model->goodsRankTop($goodsID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    /**
     * 取消置顶商品
     */
    public function rankDown()
    {
        if (IS_POST && IS_AJAX && checkSalesUserLogin()) {
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