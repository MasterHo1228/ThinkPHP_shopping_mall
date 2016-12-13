<?php
namespace Home\Controller;

use Home\Model\GoodsModel;
use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $model = new \Home\Model\GoodsModel();
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
            layout('Layout/layout');
            $this->display();
        }
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
        layout('Layout/layout');
        $this->display();
    }
}