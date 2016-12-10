<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.05
 * Time: 21:35
 */

namespace Admin\Controller;

use Think\Controller;

/**
 * 主界面独立控制类
 * Class MainController
 * @package Admin\Controller
 */
class MainController extends Controller
{
    /**
     * 加载系统主界面
     */
    public function main()
    {
        if (!checkAdminLogin() && !checkSalesUserLogin()) {
            $this->error('非法操作！', U('Admin/Index/login'));
        } else {
            $this->display();
        }
    }

    /**
     * 登出账号
     */
    public function logout()
    {
        clearSession('admin');
        clearSession('salesUID');
        clearSession('salesUName');
        $this->success('登出成功！', U('Admin/Index/login'));
    }
}