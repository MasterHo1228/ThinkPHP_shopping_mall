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
}