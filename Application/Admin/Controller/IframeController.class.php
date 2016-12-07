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

    public function goodsList()
    {
        if (session('?salesUID')) {
            $this->display('goods_list');
        } else {
            $this->error('非法操作！', U('Admin/Main/main'));
        }
    }

    public function editGoods()
    {
        if (IS_GET && session('?salesUID')) {
            $goodsID = I('get.goodsID');
            $model = D('goods');
            $data = $model->getCurrentDetailInfo($goodsID);
            if ($data) {
                $this->assign('data', $data);
                $this->display('edit_goods');
            } else {
                $this->error('商品不存在！');
            }
        } else {
            $this->error('非法操作！', U('Admin/Main/main'));
        }
    }
}