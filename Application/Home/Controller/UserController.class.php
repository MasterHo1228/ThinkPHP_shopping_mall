<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.12
 * Time: 18:20
 */

namespace Home\Controller;

use Think\Controller;

class UserController extends Controller
{
    public function login()
    {
        if (session('?user')) {
            $this->ajaxReturn('true', 'EVAL');
        } else {
            if (IS_AJAX && IS_POST) {
                $usrName = I('post.usrName/s');
                $usrPasswd = I('post.usrPasswd/s');

                $model = D('user');
                if ($model->checkAccount($usrName, $usrPasswd)) {
                    $this->ajaxReturn('true', 'EVAL');
                } else {
                    $this->ajaxReturn('false', 'EVAL');
                }
            }
        }
    }

    public function register()
    {
        if (IS_AJAX && IS_POST) {
            $usrName = I('post.usrName/s');
            $model = D('user');
            $sameName = $model->where("uName='$usrName'")->getField('uName');
            if (empty($sameName)) {
                $usrPasswd = I('post.usrPasswd/s');
                $usrPasswdT = I('post.usrPasswdT/s');
                $usrGender = I('post.usrGender/s', 'male');
                $usrEmail = I('post.usrEmail/s', '', 'email');
                $usrPhone = I('post.usrPhone/s');

                if ($usrPasswd == $usrPasswdT) {
                    if ($model->addUser($usrName, $usrPasswd, $usrGender, $usrEmail, $usrPhone)) {
                        $data['error'] = 'none';
                    } else {
                        $data['error'] = 'failed';
                    }
                } else {
                    $data['error'] = 'password';
                }
            } else {
                $data['error'] = 'name';
            }
            $this->ajaxReturn($data);
        }
    }
}