<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.13
 * Time: 21:48
 */

namespace Home\Controller;

use Home\Model\OrderModel;
use Think\Controller;

class OrderController extends Controller
{
    public function addToCart()
    {
        if (isUserLogin() && IS_AJAX && IS_POST) {
            $userID = getUserID();
            $goodsID = I('post.goodsID/d');
            $goodsCount = I('post.goodsCount/d');

            $model = new OrderModel();
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

            $model = new OrderModel();
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

            $model = new OrderModel();
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

            $model = new OrderModel();
            if ($model->clearUserCart($userID)) {
                $data['response'] = 'success';
            } else {
                $data['response'] = 'failed';
            }
            $this->ajaxReturn($data);
        }
    }

    public function placeOrder()
    {
        if (isUserLogin() && IS_AJAX && IS_POST) {
            $userID = getUserID();
            $orderCName = I('post.orderCName/s');
            $orderPhone = I('post.orderPhone/s');
            $orderAddress = I('post.orderAddress/s');
            $orderSumPrice = I('post.orderSumPrice/f');

            $model = new OrderModel();
            if ($model->placeUserOrder($userID, $orderSumPrice, $orderCName, $orderPhone, $orderAddress)) {
                $data['response'] = 'success';
            } else {
                $data['response'] = 'failed';
            }
            $this->ajaxReturn($data);
        }
    }

    public function payOrder()
    {
        if (isUserLogin() && IS_AJAX && IS_POST) {
            $userID = getUserID();
            $orderID = I('post.orderID/s');
            $payBy = I('post.payBy/s');

            $model = new OrderModel();
            if ($model->payOrder($userID, $orderID, $payBy)) {
                $data['response'] = 'success';
            } else {
                $data['response'] = 'failed';
            }
            $this->ajaxReturn($data);
        }
    }
}