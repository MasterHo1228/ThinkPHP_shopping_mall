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
    public function getSimpleList()
    {
        if (IS_AJAX && session('?salesUID')) {
            $order = M('OrderList');
            $data = $order->field('orderID,orderSumPrice,orderPaid,orderPaidBy,orderStatus')->select();
            if ($data) {
                $this->ajaxReturn($data);
            }
        }
    }
}