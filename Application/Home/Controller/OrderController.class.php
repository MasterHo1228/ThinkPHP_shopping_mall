<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.13
 * Time: 21:48
 */

namespace Home\Controller;

use Think\Controller;

class OrderController extends Controller
{
    public function addToCart()
    {
        if (isUserLogin() && IS_AJAX && IS_POST) {
            $userID = getUserID();
            $goodsID = I('post.goodsID/d');
            $goodsCount = I('post.goodsCount/d');

            $model = new \Home\Model\OrderModel();
            if ($model->goodsToUserCart($userID, $goodsID, $goodsCount)) {
                $data['response'] = 'success';
            } else {
                $data['response'] = 'failed';
            }
        } else {
            $data['response'] = 'noLogin';
        }
        $this->ajaxReturn($data);
    }

    public function changeGoodsCount()
    {
        if (isUserLogin() && IS_AJAX && IS_POST) {
            $userID = getUserID();
            $goodsID = I('post.goodsID/d');
            $goodsCount = I('post.goodsCount/d');

            $model = new \Home\Model\OrderModel();
            if (!$model->changeUserCartGoodsCount($userID, $goodsID, $goodsCount)) {
                $data['response'] = 'failed';
            } else {
                $data['response'] = 'success';
            }
            $this->ajaxReturn($data);
        }
    }

    public function dropCartGoods()
    {
        if (isUserLogin() && IS_AJAX && IS_POST) {
            $userID = getUserID();
            $goodsID = I('post.goodsID/d');

            $model = new \Home\Model\OrderModel();
            if ($model->removeCartGoodsByGID($userID, $goodsID)) {
                $data['response'] = 'success';
            } else {
                $data['response'] = 'failed';
            }
            $this->ajaxReturn($data);
        }
    }

    public function clearCart()
    {
        if (isUserLogin() && IS_AJAX) {
            $userID = getUserID();

            $model = new \Home\Model\OrderModel();
            if ($model->clearUserCart($userID)) {
                $data['response'] = 'success';
            } else {
                $data['response'] = 'failed';
            }
            $this->ajaxReturn($data);
        }
    }
}