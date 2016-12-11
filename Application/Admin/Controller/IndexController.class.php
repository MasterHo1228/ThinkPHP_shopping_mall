<?php
namespace Admin\Controller;

use Think\Controller;

/**
 * 后台管理系统初始控制类
 * Class IndexController
 * @package Admin\Controller
 */
class IndexController extends Controller
{
    /**
     * 系统登录
     */
    public function login()
    {
        if (!checkAdminLogin() && !checkSalesUserLogin()) {
            if (IS_POST) {
                $userName = I('post.usrName/s');
                $password = I('post.usrPasswd/s');
                if (D('admin')->CheckAccount($userName, $password)) {//验证是否为管理员账号登录
                    $this->redirect('backyard/Main/main');
                } else if (D('SaleUsers')->CheckAccount($userName, $password)) {//验证是否为商铺账号登录
                    $this->redirect('backyard/Main/main');
                } else {
                    $this->error('用户名或密码错误！！');
                }
                die;
            } else {
                $this->display();
            }
        } else {//若已登录 则直接跳转至系统主界面
            $this->redirect('backyard/Main/main');
        }
    }

    /**
     * 生成验证码
     */
    public function makeVCode()
    {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 16;
        $Verify->length = 4;
        $Verify->useNoise = false;
        $Verify->imageW = 120;
        $Verify->imageH = 40;
        $Verify->entry();
    }

    /**
     * AJAX 校对验证码
     */
    public function verifyVCode()
    {
        if (IS_POST) {
            $inputVCode = I('post.vCode/s');
            if (check_verify($inputVCode)) {
                $data['checked'] = 'true';
            } else {
                $data['checked'] = 'false';
            }
            $this->ajaxReturn($data);
        }
    }
}