<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.13
 * Time: 21:52
 */

namespace Home\Model;

/**
 * 前台订单模型类
 * Class OrderModel
 * @package Home\Model
 */
class OrderModel
{
    /**
     * 将商品添加到用户购物车
     * @param int $userID 用户ID
     * @param int $goodsID 商品ID
     * @param int $goodsCount 商品数量
     * @return bool|mixed
     */
    public function goodsToUserCart($userID, $goodsID, $goodsCount)
    {
        if (!empty($userID) && !empty($goodsID) && !empty($goodsCount)) {
            $where['userID'] = $userID;
            $where['goodsID'] = $goodsID;

            $model = M('UserCart');
            $existCartGoodsID = $model->where($where)->getField('goodsID');

            //检测数据表中是否有已存在的记录 有的话update记录，没有的话添加数据
            if (!empty($existCartGoodsID)) {//有已存在记录
                $existCartGoodsCount = $model->where($where)->getField('goodsCount');
                //从原来的商品数量字段更新数据
                return $model->where($where)->setField('goodsCount', $existCartGoodsCount + $goodsCount);
            } else {//没有已存在的记录
                $data['userID'] = $userID;
                $data['goodsID'] = $goodsID;
                $data['goodsCount'] = $goodsCount;

                //直接添加数据
                return $model->add($data);
            }
        } else {
            return false;
        }
    }

    /**
     * 根据用户ID查找用户购物车的数据
     * @param int $id 用户ID
     * @return bool|mixed
     */
    public function getUserCartByID($id)
    {
        if (!empty($id)) {
            $model = M('viewusercart');
            return $model->where('userID=' . $id)->field('goodsID,goodsName,goodsPrice,goodsPhoto,goodsCount')->select();
        } else {
            return false;
        }
    }

    /**
     * 更改购物车内的商品数量
     * @param int $userID 用户ID
     * @param int $goodsID 商品ID
     * @param int $goodsCount 商品数量
     * @return bool
     */
    public function changeUserCartGoodsCount($userID, $goodsID, $goodsCount)
    {
        if (!empty($userID) && !empty($goodsID)) {
            $model = M('UserCart');
            $where['userID'] = $userID;
            $where['goodsID'] = $goodsID;

            $nowGoodsCount = M('goods')->where('gID=' . $goodsID)->getField('gCount');
            if ($nowGoodsCount >= $goodsCount) {//验证更改的数量是否大于商品的库存数量
                return $model->where($where)->setField('goodsCount', $goodsCount);
            } else {
                //数据大于库存量 直接返回false
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 根据商品ID删除购物车内的商品
     * @param int $userID 用户ID
     * @param int $goodsID 商品ID
     * @return bool|mixed
     */
    public function removeCartGoodsByGID($userID, $goodsID)
    {
        if (!empty($userID) && !empty($goodsID)) {
            $where['userID'] = $userID;
            $where['goodsID'] = $goodsID;

            $model = M('UserCart');
            return $model->where($where)->delete();
        } else {
            return false;
        }
    }

    /**
     * 清除用户购物车
     * @param int $userID 用户ID
     * @return bool|mixed
     */
    public function clearUserCart($userID)
    {
        if (!empty($userID)) {
            $where['userID'] = $userID;

            $model = M('UserCart');
            return $model->where($where)->delete();
        } else {
            return false;
        }
    }

    /**
     * 创建用户在前台提交的订单
     * @param int $userID 用户ID
     * @param double $orderSumPrice 订单总价
     * @param string $orderCName 收货人姓名
     * @param string $orderPhone 订单联系电话
     * @param string $orderAddress 订单收货地址
     * @return bool
     */
    public function placeUserOrder($userID, $orderSumPrice, $orderCName, $orderPhone, $orderAddress)
    {
        if (!empty($userID) && !empty($orderCName) && !empty($orderPhone) && !empty($orderAddress)) {
            $orderID = generateOrderNum();
            session('user.makeOrderID', $orderID);
            $data['orderID'] = $orderID;
            $data['orderUserID'] = $userID;
            $data['orderSumPrice'] = $orderSumPrice;
            $data['orderCName'] = $orderCName;
            $data['orderAddress'] = $orderAddress;
            $data['orderPhone'] = $orderPhone;

            if (M('OrderList')->add($data)) {//若已成功创建订单 则将用户购物车中的数据转移到订单详单表中
                $userCart = M('UserCart');
                //获取购物车中的所有商品
                $orderGoodsList = $userCart->where('userID=' . $userID)->field('goodsID,goodsCount')->select();

                $orderListItem = M('OrderListItem');
                $goods = M('goods');

                foreach ($orderGoodsList as $item) {//使用循环 将购物车中的商品数据转移到订单详单表
                    $itemData['orderID'] = $orderID;
                    $itemData['orderGID'] = $item['goodsid'];
                    $itemData['orderGCount'] = $item['goodscount'];

                    //数据转移成功后 更新商品的库存量以及商品销量数据
                    if ($orderListItem->add($itemData)) {
                        //删除已从购物车中转移的数据
                        $userCart->where('userID=' . $userID . ' AND goodsID=' . $item['goodsid'])->delete();

                        //更新商品库存量及销量
                        $thisGoodsCount = $goods->where('gID=' . $item['goodsid'])->getField('gCount');
                        $goods->where('gID=' . $item['goodsid'])->setField('gCount', $thisGoodsCount - $item['goodscount']);
                        $thisGoodsSoldNum = $goods->where('gID=' . $item['goodsid'])->getField('gSoldOutNum');
                        $goods->where('gID=' . $item['goodsid'])->setField('gSoldOutNum', $thisGoodsSoldNum + $item['goodscount']);
                    } else {
                        break;
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 前台支付订单
     * @param int $userID 用户ID
     * @param string $orderID 订单号
     * @param string $payBy 支付方式
     * @return bool
     */
    public function payOrder($userID, $orderID, $payBy)
    {
        if (!empty($userID) && !empty($orderID) && ($payBy == 'alipay' || $payBy == 'wechat')) {
            $orderList = M('OrderList');

            //验证订单状态及订单支付状态
//            $orderStatus = $orderList->where("orderID='$orderID' AND orderUserID=$userID")->getField('orderStatus');
//            $orderIsPaid = $orderList->where("orderID='$orderID' AND orderUserID=$userID")->getField('orderPaid');
            $orderStatus = $this->checkOrderStatus($orderID);
            $orderIsPaid = $this->checkOrderPaid($orderID);
            if ($orderIsPaid == '1') {
                return 'paid';
            } else if ($orderIsPaid == '0' && $orderStatus == '1') {//若订单处于未支付且正常的状态 则继续以下操作
                $data['orderPaid'] = '1';
                $data['orderPaidBy'] = $payBy;
                return $orderList->where("orderID='$orderID' AND orderUserID=$userID")->save($data);
            } else {
                //否则终止操作
                return false;
            }
        } else {
            return false;
        }
    }

    public function checkOrderStatus($orderID)
    {
        if (!empty($orderID)) {
            $orderList = M('OrderList');
            $orderStatus = $orderList->where("orderID='$orderID'")->getField('orderStatus');
            return $orderStatus;
        } else {
            return false;
        }
    }

    public function checkOrderPaid($orderID)
    {
        if (!empty($orderID)) {
            $orderList = M('OrderList');
            $orderIsPaid = $orderList->where("orderID='$orderID'")->getField('orderPaid');
            return $orderIsPaid;
        } else {
            return false;
        }
    }

    public function showUserOrdersByUserID($id)
    {
        if (!empty($id)) {
            $order = M('vieworderinfo');
            $orderList = $order->where('orderUserID=' . $id)->field('orderID,orderSumPrice,orderPaid,orderPaidBy,orderStatus')->select();
            if ($orderList) {
                $orderGoods = M('viewordergoodsinfo');
                for ($i = 0; $i < count($orderList); $i++) {
                    $thisOrderID = $orderList[$i]['orderid'];
                    $orderList[$i]['ordergoodsid'] = $orderGoods->where("orderID='$thisOrderID'")->getField('orderGID');
                    $orderList[$i]['ordergoodsimg'] = $orderGoods->where("orderID='$thisOrderID'")->getField('goodsPhoto');
                    $orderList[$i]['ordergoodsname'] = $orderGoods->where("orderID='$thisOrderID'")->getField('goodsName');
                }

                return $orderList;
            } elseif ($orderList == null) {
                return null;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}