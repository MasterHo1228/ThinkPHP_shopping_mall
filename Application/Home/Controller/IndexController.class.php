<?php
namespace Home\Controller;

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

        $rowCount = count($list) / 3;
        if ($rowCount < 1) {
            $rowCount = 1;
        }

        dump($list);
        $this->assign('list', $list);
        $this->assign('rowCount', $rowCount);
        $this->assign('top3', $top3);
        layout('Layout/layout');
        $this->display();
    }

    public function register()
    {
        layout('Layout/layout');
        $this->display();
    }

    public function login()
    {
        layout('Layout/layout');
        $this->display();
    }

    public function single()
    {
        layout('Layout/layout');
        $this->display();
    }
}