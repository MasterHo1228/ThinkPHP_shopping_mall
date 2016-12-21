<?php
namespace Home\Controller;

use Home\Model\GoodsModel;
use Home\Model\OrderModel;
use Think\Controller;

/**
 * 前台主操作类
 * Class IndexController
 * @package Home\Controller
 */
class IndexController extends Controller
{
    /**
     * 主页
     */
    public function index()
    {
        $model = new GoodsModel();
        $list = $model->getIndexList();
        $top3 = $model->getTop3Goods();

        //获取首页推介商品对应的商品描述 反转义符号并去掉html标记
        for ($i = 0; $i < count($top3); $i++) {
            $top3[$i]['gdescription'] = html_entity_decode($top3[$i]['gdescription'], ENT_NOQUOTES, "utf-8");
            $top3[$i]['gdescription'] = strip_tags($top3[$i]['gdescription']);
        }

        //控制列表行数
        $rowCount = count($list) / 4;
        if ($rowCount < 1) {
            $rowCount = 1;
        }

        $this->assign('list', $list);
        $this->assign('rowCount', $rowCount);
        $this->assign('top3', $top3);
        layout('Layout/layout');
        $this->display();
    }

    public function login()
    {
        if (isUserLogin()) {
            //若已登录账号 则自动跳转到首页
            $this->redirect('index');
        } else {
            $this->assign('isAccountPage', 'true');
            $this->assign('noNavTab', 'true');
            layout('Layout/layout');
            $this->display();
        }
    }

    public function register()
    {
        if (isUserLogin()) {
            //若已登录账号 则自动跳转到首页
            $this->redirect('index');
        } else {
            $this->assign('isAccountPage', 'true');
            $this->assign('noNavTab', 'true');
            layout('Layout/layout');
            $this->display();
        }
    }

    public function products()
    {
        if (IS_GET && I('get.type') != null) {
            $goodsType = I('get.type/s');
            $model = new GoodsModel();
            $list = $model->getListByGoodsType($goodsType);

            if (count($list) == 0) {
                //若没有对应条件的商品 则前台提示无商品
                $this->assign('emptyResult', 'true');
            } else {
                //控制列表行数
                $rowCount = count($list) / 4;
                if ($rowCount < 1) {
                    $rowCount = 1;
                }
            }
            //获取该商品的类型名称
            $thisTypeName = M('goodstype')->where("tID='$goodsType'")->getField('tName');

            $this->assign('list', $list);
            $this->assign('typeName', $thisTypeName);
            $this->assign('rowCount', $rowCount);

            layout('Layout/layout');
            $this->display();
        } else {
            $this->error('非法操作！', U('index'));
        }
    }

    public function search()
    {
        $searchKey = I('get.searchKey/s');

        $model = new GoodsModel();
        $list = $model->getListBySearchKey($searchKey);
        if (count($list) == 0) {
            //若没有对应条件的商品 则前台提示无商品
            $this->assign('emptyResult', 'true');
        } else {
            //控制列表行数
            $rowCount = count($list) / 4;
            if ($rowCount < 1) {
                $rowCount = 1;
            }
        }

        $this->assign('list', $list);
        $this->assign('rowCount', $rowCount);
        layout('Layout/layout');
        $this->display();
    }

    public function single()
    {
        $goodsID = I('get.goodsID/d');
        $model = new GoodsModel();

        $data = $model->getDetailByID($goodsID);

        if ($data) {
            //商品描述 反转义字符
            $data['gdescription'] = html_entity_decode($data['gdescription'], ENT_QUOTES, 'UTF-8');

            $this->assign('data', $data);
            $top3 = $model->getTop3Goods();

            //获取近期推荐及新上架的商品列表
            $this->assign('top3', $top3);
            $latestList = $model->getLatestList();
            $this->assign('latest', $latestList);

            layout('Layout/layout');
            $this->display();
        } else {
            $this->error('非法操作！', U('index'));
        }
    }

    public function cart()
    {
        if (isUserLogin()) {
            $userID = getUserID();
            $model = new OrderModel();

            $data = $model->getUserCartByID($userID);
            if ($data) {
                //购物车表中有数据时往前台返回数据
                $this->assign('data', $data);
            }

            //屏蔽导航条
            $this->assign('noNavTab', 'true');
            layout('Layout/layout');
            $this->display();
        } else {
            $this->error('非法操作！', U('index'));
        }
    }

    public function makeOrder()
    {
        if (isUserLogin()) {
            $userID = getUserID();
            $model = new OrderModel();

            $data = $model->getUserCartByID($userID);
            if (!$data) {
                //用户购物车没有数据时强制返回
                $this->error('操作失败！');
                die();
            }

            //计算购物车商品总价
            $sumPrice = 0;
            for ($i = 0; $i < count($data); $i++) {
                $count = $data[$i]['goodscount'];
                $price = $data[$i]['goodsprice'];

                $sumPrice += $price * $count;
            }

            $this->assign('data', $data);
            $this->assign('sumPrice', $sumPrice);

            //屏蔽导航条
            $this->assign('noNavTab', 'true');
            layout('Layout/layout');
            $this->display('make_order');
        } else {
            $this->error('非法操作！', U('index'));
        }
    }

    public function payOrder()
    {
        if (isUserLogin()) {
            if (!empty(I('get.orderID'))) {
                $orderID = I('get.orderID/s');
                $this->assign('payType', 'after');
            } else if (session('?user.makeOrderID')) {
                $orderID = session('user.makeOrderID');
                $this->assign('payType', 'now');
            }

            $model = new OrderModel();
            $orderPaid = $model->checkOrderPaid($orderID);
            $orderStatus = $model->checkOrderStatus($orderID);
            if ($orderPaid == '0' && $orderStatus == '1') {
                $this->assign('orderID', $orderID);

                //屏蔽导航条
                $this->assign('noNavTab', 'true');
                layout('Layout/layout');
                $this->display('payment');
            } else if ($orderPaid == '1' && $orderStatus == '1') {
                $this->redirect('Index/user', null, 5, '订单已支付，无需重复支付！');
            } else if ($orderStatus == '0') {
                $this->redirect('Index/user', null, 5, '订单已被取消！');
            }
        }
    }

    public function user()
    {
        if (isUserLogin()) {
            $userID = session('user.usrID');
            $model = new OrderModel();
            $data = $model->showUserOrdersByUserID($userID);
            for ($i = 0; $i < count($data); $i++) {
                switch ($data[$i]['orderstatus']) {
                    case '0':
                        $data[$i]['orderstatusW'] = '已取消';
                        break;
                    case '1':
                        if ($data[$i]['orderpaid'] == '1') {
                            $data[$i]['orderstatusW'] = '已付款';
                        } else if ($data[$i]['orderpaid'] == '0') {
                            $data[$i]['orderstatusW'] = '未付款';
                        }
                        break;
                    case '2':
                        $data[$i]['orderstatusW'] = '已发货';
                        break;
                    case '3':
                        $data[$i]['orderstatusW'] = '已收货';
                        break;
                }
            }
            $this->assign('orderData', $data);

            //屏蔽导航条
            $this->assign('noNavTab', 'true');
            layout('Layout/layout');
            $this->display('user_info');
        } else {
            $this->error('非法操作！', U('index'));
        }
    }

    public function orderDetail()
    {
        if (isUserLogin() && IS_GET && !empty(I('get.orderID'))) {
            $orderID = I('get.orderID/s');
            $userID = getUserID();

            $model = new OrderModel();
            $data = $model->getOrderMainInfo($userID, $orderID);
            if ($data) {
                $this->assign('data', $data);

                $goodsList = $model->getOrderGoodsList($orderID);
                $this->assign('goodsList', $goodsList);
                $this->assign('noNavTab', 'true');
                layout('Layout/layout');
                $this->display('order_detail');
            } else {
                $this->error('抱歉，暂时无法查询该订单的详细数据！', U('index'));
            }
        } else {
            $this->error('非法操作！', U('index'));
        }
    }
}