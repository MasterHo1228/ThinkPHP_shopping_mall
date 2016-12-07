<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.05
 * Time: 22:57
 */

namespace Admin\Controller;

use Think\Controller;

class IframeController extends Controller
{
    public function welcome()
    {
        $log = M('AdminLoginLog');
        $userID = session('admin.usrID');
        $logData = $log->where("adminID=$userID")->order('adminLoginTime desc')->field('adminLoginTime,adminLoginIP')->limit(1, 1)->select();
        $logTime = $logData[0]['adminlogintime'];
        $logIP = $logData[0]['adminloginip'];

        $this->assign('loginTime', $logTime);
        $this->assign('loginIpAddr', $logIP);
        $this->display();
    }
}