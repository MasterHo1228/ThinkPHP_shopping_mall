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

    public function getCurrentInfo()
    {
        if (IS_GET && session('?salesUID')) {
            $orderID = I('get.orderID/s');
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
}