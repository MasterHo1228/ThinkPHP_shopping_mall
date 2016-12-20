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

/**
 * 前台订单操作类
 * Class OrderController
 * @package Home\Controller
 */
class OrderController extends Controller
{
    /**
     * 商品添加到购物车
     */
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

    /**
     * 更改购物车中商品的数量
     */
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

    /**
     * 删除购物车中的商品
     */
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

    /**
     * 清空购物车
     */
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

    /**
     * 获取用户订单的收货信息 并创建订单
     */
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

    /**
     * 订单支付
     */
    public function payOrder()
    {
        if (isUserLogin() && IS_AJAX && IS_POST) {
            $userID = getUserID();
            $orderID = I('post.orderID/s');
            $payBy = I('post.payBy/s');

            $model = new OrderModel();
            $result = $model->payOrder($userID, $orderID, $payBy);
            if ($result) {
                $data['response'] = 'success';
            } else if ($result == 'paid') {
                $data['response'] = 'paid';
            } else {
                $data['response'] = 'failed';
            }
            $this->ajaxReturn($data);
        }
    }
}