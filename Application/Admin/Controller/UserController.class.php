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
 * 商城用户操作类
 * Class UserController
 * @package Admin\Controller
 */
class UserController extends Controller
{
    /**
     * 获取商城用户列表
     */
    public function getList()
    {
        if (IS_AJAX && checkAdminLogin()) {
            $model = D('user');
            $data = $model->getAllUserList();
            $this->ajaxReturn($data);
        }
    }

    /**
     * 获取相应用户详细信息
     */
    public function getCurrentInfo()
    {
        if (IS_AJAX && IS_GET && checkAdminLogin()) {
            $userID = I('get.userID/d');
            $model = D('user');
            $data = $model->getInfoByID($userID);
            $this->ajaxReturn($data);
        }
    }

    /**
     * 更新用户信息
     */
    public function update()
    {
        if (IS_AJAX && IS_POST && checkAdminLogin()) {
            $userID = I('post.userID/d');
            $userName = I('post.userName/s');
            $userPasswd = I('post.userPasswd/s');
            $userGender = I('post.userGender/s');
            $userEmail = I('post.userEmail/s');
            $userPhone = I('post.userPhone/s');

            $model = D('user');
            if ($model->updateInfo($userID, $userName, $userPasswd, $userGender, $userEmail, $userPhone)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    /**
     * 删除用户
     */
    public function delete()
    {
        if (IS_AJAX && IS_POST && checkAdminLogin()) {
            $userID = I('post.userID/d');
            $model = D('user');

            if ($model->deleteByID($userID)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }
}