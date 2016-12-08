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
}