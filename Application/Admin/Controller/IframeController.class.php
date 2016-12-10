<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.05
 * Time: 22:57
 */

namespace Admin\Controller;

use Think\Controller;

/**
 * Iframe 独立控制类
 * Class IframeController
 * @package Admin\Controller
 */
class IframeController extends Controller
{
    /**
     * 显示欢迎页
     */
    public function welcome()
    {
        if (checkAdminLogin()) {
            $log = M('AdminLoginLog');
            $userID = session('admin.usrID');
            $logData = $log->where("adminID=$userID")->order('adminLoginTime desc')->field('adminLoginTime,adminLoginIP')->limit(1, 1)->select();
            $logTime = $logData[0]['adminlogintime'];
            $logIP = $logData[0]['adminloginip'];

            $this->assign('loginTime', $logTime);
            $this->assign('loginIpAddr', $logIP);
        }
        $this->display();
    }

    /**
     * 显示商品列表页
     */
    public function goodsList()
    {
        if (checkSalesUserLogin()) {
            $this->display('goods_list');
        } else {
            $this->error('非法操作！', U('Admin/Main/main'));
        }
    }

    /**
     * 编辑商品信息页
     */
    public function editGoods()
    {
        if (IS_GET && checkSalesUserLogin()) {
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

    /**
     * 订单列表页
     */
    public function orderList()
    {
        if (checkSalesUserLogin()) {
            $this->display('order_list');
        } else {
            $this->error('非法操作！', U('Admin/Main/main'));
        }
    }

    /**
     * 查看管理员登录日志页
     * (主管理员)查看所有管理员登录日志
     * (普通管理员)查看该管理员登录日志
     */
    public function adminLog()
    {
        if (checkAdminLogin()) {
            $model = M('viewadminlog');
            $adminName = session('admin.usrName');
            if ($adminName == 'admin') {
                $data = $model->order('adminLoginTime desc')->limit(20)->select();
            } else {
                $data = $model->where("adminName='$adminName'")->order('adminLoginTime desc')->limit(20)->select();
            }

            $this->assign('data', $data);
            $this->display('admin_log');
        } else {
            $this->error('非法操作！', U('Admin/Main/main'));
        }
    }

    /**
     * 管理员账号列表页
     */
    public function adminList()
    {
        if (checkAdminLogin() && isRealAdmin()) {
            $this->display('admin_list');
        } else {
            $this->error('非法操作！', U('Admin/Main/main'));
        }
    }

    /**
     * 商城用户列表页
     */
    public function userList()
    {
        if (checkAdminLogin()) {
            $this->display('user_list');
        } else {
            $this->error('非法操作！', U('Admin/Main/main'));
        }
    }

    /**
     * 商铺账号列表页
     */
    public function salesUserList()
    {
        if (checkAdminLogin()) {
            $this->display('salesuser_list');
        } else {
            $this->error('非法操作！', U('Admin/Main/main'));
        }
    }
}