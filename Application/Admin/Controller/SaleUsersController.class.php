<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.08
 * Time: 16:32
 */

namespace Admin\Controller;

use Think\Controller;

/**
 * 商铺账号控制类
 * Class SaleUsersController
 * @package Admin\Controller
 */
class SaleUsersController extends Controller
{
    /**
     * 获取所有商铺账号列表
     */
    public function getList()
    {
        if (IS_AJAX && checkAdminLogin()) {
            $model = D('SaleUsers');
            $data = $model->getAllShopList();
            $this->ajaxReturn($data);
        }
    }

    /**
     * 获取相应商铺账号信息
     */
    public function getCurrentInfo()
    {
        if (IS_AJAX && IS_POST && checkAdminLogin()) {
            $userID = I('post.salesUID/d');
            $model = D('SaleUsers');
            $data = $model->getInfoByID($userID);
            $this->ajaxReturn($data);
        }
    }

    /**
     * 添加商铺账号
     */
    public function add()
    {
        if (IS_POST && IS_AJAX && checkAdminLogin()) {
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

    /**
     * 更新商铺账号信息
     */
    public function update()
    {
        if (IS_AJAX && IS_POST && checkAdminLogin()) {
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

    /**
     * 删除商铺账号
     */
    public function delete()
    {
        if (IS_AJAX && IS_POST && checkAdminLogin()) {
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