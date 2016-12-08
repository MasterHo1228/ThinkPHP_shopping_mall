<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.08
 * Time: 16:32
 */

namespace Admin\Controller;

use Think\Controller;

class UserController extends Controller
{
    public function getList()
    {
        if (IS_AJAX && session('?admin')) {
            $model = D('user');
            $data = $model->getAllUserList();
            $this->ajaxReturn($data);
        }
    }

    public function getCurrentInfo()
    {
        if (IS_AJAX && IS_GET && session('?admin')) {
            $userID = I('get.userID/d');
            $model = D('user');
            $data = $model->getInfoByID($userID);
            $this->ajaxReturn($data);
        }
    }

    public function update()
    {
        if (IS_AJAX && IS_POST && session('?admin')) {
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

    public function delete()
    {
        if (IS_AJAX && IS_POST && session('?admin')) {
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