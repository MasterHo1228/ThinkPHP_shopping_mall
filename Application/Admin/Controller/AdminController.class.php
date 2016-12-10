<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/8
 * Time: 9:34
 */

namespace Admin\Controller;

use Think\Controller;

/**
 * 管理员操作类
 * Class AdminController
 * @package Admin\Controller
 */
class AdminController extends Controller
{

    /**
     * 获取管理员账号列表
     */
    public function getList()
    {
        if (IS_AJAX && checkAdminLogin() && isRealAdmin()) {
            $model = D('admin');
            $data = $model->getNormalAdminList();
            $this->ajaxReturn($data);
        }
    }

    /**
     * 根据管理员ID AJAX返回管理员用户名
     */
    public function ajaxGetName()
    {
        if (IS_AJAX && IS_POST && checkAdminLogin() && isRealAdmin()) {
            $adminID = I('post.adminID/d');
            $model = D('admin');
            $data = $model->getName($adminID);
            $this->ajaxReturn($data, 'EVAL');
        }
    }

    /**
     * 添加管理员账号
     */
    public function add()
    {
        if (IS_AJAX && IS_POST && checkAdminLogin() && isRealAdmin()) {
            $model = D('admin');
            $data['aName'] = I('post.adminName/s');
            $data['aPassword'] = I('post.password/s');

            if ($model->add($data)) {
                $this->ajaxReturn('true', 'EVAL');
            } else {
                $this->ajaxReturn('false', 'EVAL');
            }
        }
    }

    /**
     * 更新管理员账号
     */
    public function update()
    {
        if (IS_AJAX && IS_POST && checkAdminLogin() && isRealAdmin()) {
            $adminID = I('post.adminID/d');
            $model = D('admin');
            if (I('post.type/s') == 'password' && !empty(I('post.password/s'))) {
                if ($model->changePassword($adminID, I('post.password/s'))) {
                    $this->ajaxReturn('true', 'EVAL');
                } else {
                    $this->ajaxReturn('false', 'EVAL');
                }
            }
        }
    }

    /**
     * 删除管理员账号
     */
    public function delete()
    {
        if (IS_AJAX && IS_POST && checkAdminLogin() && isRealAdmin()) {
            $adminID = I('post.adminID/d');
            $model = D('admin');

            if ($adminID != 1) {
                if ($model->deleteByID($adminID)) {
                    $this->ajaxReturn('true', 'EVAL');
                } else {
                    $this->ajaxReturn('false', 'EVAL');
                }
            }
        }
    }
}