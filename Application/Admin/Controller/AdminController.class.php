<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/8
 * Time: 9:34
 */

namespace Admin\Controller;

use Think\Controller;

class AdminController extends Controller
{
    public function getList()
    {
        if (IS_AJAX && session('?admin') && session('admin.usrName') == 'admin') {
            $model = D('admin');
            $data = $model->getNormalAdminList();
            $this->ajaxReturn($data);
        }
    }

    public function ajaxGetName()
    {
        if (IS_AJAX && IS_POST && session('?admin') && session('admin.usrName') == 'admin') {
            $adminID = I('post.adminID/d');
            $model = D('admin');
            $data = $model->getName($adminID);
            $this->ajaxReturn($data, 'EVAL');
        }
    }

    public function add()
    {
        if (IS_AJAX && IS_POST && session('?admin') && session('admin.usrName') == 'admin') {
            $model = D('admin');
            $data['aName'] = I('post.adminName/s');
            $data['aPassword'] = I('post.password/s');

            if ($model->add($data)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    public function update()
    {
        if (IS_AJAX && IS_POST && session('?admin') && session('admin.usrName') == 'admin') {
            $adminID = I('post.adminID/d');
            $model = D('admin');
            if (I('post.type/s') == 'password' && !empty(I('post.password/s'))) {
                if ($model->changePassword($adminID, I('post.password/s'))) {
                    $this->ajaxReturn('true', 'EVAL');
                } else {
                    $this->ajaxReturn('false', 'EVAL');
                }
            }
        }
    }

    public function delete()
    {
        if (IS_AJAX && IS_POST && session('?admin') && session('admin.usrName') == 'admin') {
            $adminID = I('post.adminID/d');
            $model = D('admin');

            if ($adminID != 1) {
                if ($model->deleteByID($adminID)) {
                    $this->ajaxReturn('true', 'EVAL');
                } else {
                    $this->ajaxReturn('false', 'EVAL');
                }
            }
        }
    }
}