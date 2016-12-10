<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/9
 * Time: 9:52
 */

namespace Admin\Controller;

use Think\Controller;

/**
 * 订单独立控制类
 * Class OrderController
 * @package Admin\Controller
 */
class OrderController extends Controller
{
    /**
     * 获取订单列表
     */
    public function getList()
    {
        if (IS_AJAX && checkSalesUserLogin()) {
            $order = M('OrderList');
            $data = $order->field('orderID,orderSumPrice,orderPaid,orderPaidBy,orderStatus')->select();
            if ($data) {
                $this->ajaxReturn($data);
            }
        }
    }

    /**
     * 获取单个订单简略信息
     */
    public function getCurrentSimpleInfo()
    {
        if (IS_AJAX && IS_POST && checkSalesUserLogin()) {
            $orderID = I('post.orderID/s');
            $orderList = M('vieworderinfo');

            $data = $orderList->where("orderID='$orderID'")->field('orderID,orderCName,orderAddress,orderPhone')->find();
            if ($data) {
                $this->ajaxReturn($data);
            }
        }
    }

    /**
     * 获取订单详细信息
     */
    public function getCurrentDetailInfo()
    {
        if (IS_AJAX && IS_POST && checkSalesUserLogin()) {
            $orderID = I('post.orderID/s');
            $orderList = M('vieworderinfo');

            //获取订单详细信息
            $data1 = $orderList->where("orderID='$orderID'")->field('orderID,orderSumPrice,orderCName,orderAddress,orderPhone,expressName,expressNum,orderPaid,orderPaidBy,orderStatus')->find();
            if ($data1) {
                $output = $data1;
                //获取订单商品信息
                $orderItem = M('viewordergoodsinfo');
                $data2 = $orderItem->where("orderID='$orderID'")->field('goodsName,goodsPrice,goodsCount')->select();
                if ($data2 != false) {
                    if ($data2 != null) {
                        $output['goods'] = $data2;
                    } else {
                        $output['goods'] = null;
                    }
                    //AJAX返回数据
                    $this->ajaxReturn($output);
                }
            }
        }
    }

    /**
     * 订单发货
     */
    public function send()
    {
        if (IS_AJAX && IS_POST && checkSalesUserLogin()) {
            $orderID = I('post.orderID/s');
            $data['expressID'] = I('post.expressID/d');
            $data['expressNum'] = I('post.expressNum/s');

            $orderList = M('OrderList');
            if ($orderList->where("orderID='$orderID'")->save($data)) {
                $orderList->where("orderID='$orderID'")->setField('orderStatus', '2');
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    /**
     * 取消订单
     */
    public function cancel()
    {
        if (IS_AJAX && IS_POST && checkSalesUserLogin()) {
            $orderID = I('post.orderID/s');
            $orderList = M('OrderList');

            $status = $orderList->where("orderID='$orderID'")->getField('orderStatus');
            if ($status != '0' && $status != '3') {
                if ($orderList->where("orderID='$orderID'")->setField('orderStatus', '0')) {
                    $this->ajaxReturn('true', 'EVAL');
                } else {
                    $this->ajaxReturn('false', 'EVAL');
                }
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }
}