<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/9
 * Time: 9:52
 */

namespace Admin\Controller;

use Think\Controller;

class OrderController extends Controller
{
    public function getList()
    {
        if (IS_AJAX && session('?salesUID')) {
            $order = M('OrderList');
            $data = $order->field('orderID,orderSumPrice,orderPaid,orderPaidBy,orderStatus')->select();
            if ($data) {
                $this->ajaxReturn($data);
            }
        }
    }

    public function getCurrentSimpleInfo()
    {
        if (IS_AJAX && IS_POST && session('?salesUID')) {
            $orderID = I('post.orderID/s');
            $orderList = M('vieworderinfo');

            $data = $orderList->where("orderID='$orderID'")->field('orderID,orderCName,orderAddress,orderPhone')->find();
            if ($data) {
                $this->ajaxReturn($data);
            }
        }
    }

    public function getCurrentDetailInfo()
    {
        if (IS_AJAX && IS_POST && session('?salesUID')) {
            $orderID = I('post.orderID/s');
            $orderList = M('vieworderinfo');

            $data1 = $orderList->where("orderID='$orderID'")->field('orderID,orderSumPrice,orderCName,orderAddress,orderPhone,expressName,expressNum,orderPaid,orderPaidBy,orderStatus')->find();
            if ($data1) {
                $output = $data1;
                $orderItem = M('viewordergoodsinfo');
                $data2 = $orderItem->where("orderID='$orderID'")->field('goodsName,goodsPrice,goodsCount')->select();
                if ($data2 != false) {
                    if ($data2 != null) {
                        $output['goods'] = $data2;
                    } else {
                        $output['goods'] = null;
                    }
                    $this->ajaxReturn($output);
                }
            }
        }
    }

    public function send()
    {
        if (IS_AJAX && IS_POST && session('?salesUID')) {
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

    public function cancel()
    {
        if (IS_AJAX && IS_POST && session('?salesUID')) {
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