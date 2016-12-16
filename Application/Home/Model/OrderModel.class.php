<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.13
 * Time: 21:52
 */

namespace Home\Model;

class OrderModel
{
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
                return $model->where($where)->setField('goodsCount', $existCartGoodsCount + $goodsCount);
            } else {//没有已存在的记录
                $data['userID'] = $userID;
                $data['goodsID'] = $goodsID;
                $data['goodsCount'] = $goodsCount;

                return $model->add($data);
            }
        } else {
            return false;
        }
    }

    public function getUserCartByID($id)
    {
        if (!empty($id)) {
            $model = M('viewusercart');
            return $model->where('userID=' . $id)->field('goodsID,goodsName,goodsPrice,goodsPhoto,goodsCount')->select();
        } else {
            return false;
        }
    }

    public function changeUserCartGoodsCount($userID, $goodsID, $goodsCount)
    {
        if (!empty($userID) && !empty($goodsID)) {
            $model = M('UserCart');
            $where['userID'] = $userID;
            $where['goodsID'] = $goodsID;

            $nowGoodsCount = M('goods')->where('gID=' . $goodsID)->getField('gCount');
            if ($nowGoodsCount >= $goodsCount) {
                return $model->where($where)->setField('goodsCount', $goodsCount);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

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

    public function placeUserOrder($userID, $orderSumPrice, $orderCName, $orderPhone, $orderAddress)
    {
        if (!empty($userID) && !empty($orderCName) && !empty($orderPhone) && !empty($orderAddress)) {
            $orderID = generateOrderNum();
            session('user.makeOrderID', $orderID);
            $data['orderID'] = $orderID;
            $data['orderSumPrice'] = $orderSumPrice;
            $data['orderCName'] = $orderCName;
            $data['orderAddress'] = $orderAddress;
            $data['orderPhone'] = $orderPhone;

            if (M('OrderList')->add($data)) {
                $userCart = M('UserCart');
                $orderGoodsList = $userCart->where('userID=' . $userID)->field('goodsID,goodsCount')->select();

                $orderListItem = M('OrderListItem');
                $goods = M('goods');

                foreach ($orderGoodsList as $item) {
                    $itemData['orderID'] = $orderID;
                    $itemData['orderGID'] = $item['goodsid'];
                    $itemData['orderGCount'] = $item['goodscount'];

                    if ($orderListItem->add($itemData)) {
                        $userCart->where('userID=' . $userID . ' AND goodsID=' . $item['goodsid'])->delete();

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
}