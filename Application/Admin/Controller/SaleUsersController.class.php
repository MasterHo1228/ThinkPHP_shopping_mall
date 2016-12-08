<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.08
 * Time: 16:32
 */

namespace Admin\Controller;

use Think\Controller;

class SaleUsersController extends Controller
{
    public function getList()
    {
        if (IS_AJAX && session('?admin')) {
            $model = D('SaleUsers');
            $data = $model->getAllShopList();
            $this->ajaxReturn($data);
        }
    }

    public function getCurrentInfo()
    {
        if (IS_AJAX && IS_GET && session('?admin')) {
            $userID = I('get.salesUID/d');
            $model = D('SaleUsers');
            $data = $model->getInfoByID($userID);
            $this->ajaxReturn($data);
        }
    }

    public function add()
    {
        if (IS_POST && IS_AJAX && session('?admin')) {
            $SULoginName = I('post.SULoginName/s');
            $SUPasswd = I('post.SUPasswd/s');
            $SUName = I('post.SUName/s');

            $model = D('SaleUsers');
            if ($model->addShop($SULoginName, $SUPasswd, $SUName)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    public function update()
    {
        if (IS_AJAX && IS_POST && session('?admin')) {
            $salesUID = I('post.salesUID/d');
            $SULoginName = I('post.SULoginName/s');
            $SUPasswd = I('post.SUPasswd/s');
            $SUName = I('post.SUName/s');

            $model = D('SaleUsers');
            if ($model->updateInfo($salesUID, $SULoginName, $SUPasswd, $SUName)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    public function delete()
    {
        if (IS_AJAX && IS_POST && session('?admin')) {
            $userID = I('post.salesUID/d');
            $model = D('SaleUsers');

            if ($model->deleteByID($userID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }
}