<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function login()
    {
        if (!session('?admin')) {
            if (IS_POST) {
                $userName = I('post.usrName');
                $password = I('post.usrPasswd');
                $model = D('admin');
                if ($model->CheckAccount($userName, $password)) {
                    $this->redirect('Admin/Main/main');
                } else {
                    $this->error('用户名或密码错误！！');
                }
                die;
            } else {
                $this->display();
            }
        } else {
            $this->redirect('Admin/Main/main');
        }
    }

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