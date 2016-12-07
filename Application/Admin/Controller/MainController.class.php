<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.05
 * Time: 21:35
 */

namespace Admin\Controller;

use Think\Controller;

class MainController extends Controller
{
    public function main()
    {
        if (!checkLogin()) {
            $this->error('非法操作！', U('Admin/Index/login'));
        } else {
            $this->display();
        }
    }

    public function logout()
    {
        clearSession('admin');
        clearSession('salesUID');
        $this->success('登出成功！', U('Admin/Index/login'));
    }
}