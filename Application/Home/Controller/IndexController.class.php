<?php
namespace Home\Controller;

use Home\Model\GoodsModel;
use Home\Model\OrderModel;
use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $model = new GoodsModel();
        $list = $model->getIndexList();
        $top3 = $model->getTop3Goods();

        for ($i = 0; $i < count($top3); $i++) {
            $top3[$i]['gdescription'] = html_entity_decode($top3[$i]['gdescription'], ENT_NOQUOTES, "utf-8");
            $top3[$i]['gdescription'] = strip_tags($top3[$i]['gdescription']);
        }

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
                $this->assign('emptyResult', 'true');
            } else {
                $rowCount = count($list) / 4;
                if ($rowCount < 1) {
                    $rowCount = 1;
                }
            }
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
            $this->assign('emptyResult', 'true');
        } else {
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
            $data['gdescription'] = html_entity_decode($data['gdescription'], ENT_QUOTES, 'UTF-8');

            $this->assign('data', $data);
            $top3 = $model->getTop3Goods();
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
                $this->assign('data', $data);
            }

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
                $this->error('操作失败！');
                die();
            }

            $sumPrice = 0;
            for ($i = 0; $i < count($data); $i++) {
                $count = $data[$i]['goodscount'];
                $price = $data[$i]['goodsprice'];

                $sumPrice += $price * $count;
            }

            $this->assign('data', $data);
            $this->assign('sumPrice', $sumPrice);
            $this->assign('noNavTab', 'true');
            layout('Layout/layout');
            $this->display('make_order');
        } else {
            $this->error('非法操作！', U('index'));
        }
    }

    public function payOrder()
    {
        $this->assign('noNavTab', 'true');
        layout('Layout/layout');
        $this->display('payment');
    }
}