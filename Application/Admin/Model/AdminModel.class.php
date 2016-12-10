<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 16:23
 */

namespace Admin\Model;

use Think\Model;

/**
 * 管理员账号模型类
 * Class AdminModel
 * @package Admin\Model
 */
class AdminModel extends Model
{
    /**
     * 登录账号验证
     * @param string $UserName 用户名
     * @param string $Password 密码
     * @return bool
     */
    public function CheckAccount($UserName, $Password)
    {
        //获取用户名
        $where['aName'] = $UserName;

        //获取相应账号的密码及掩码
        $tmp_Password = $this->where($where)->getField('aPassword');
        $tmp_salt = $this->where($where)->getField('aSalt');

        if (md5($Password . $tmp_salt) == $tmp_Password) {//验证密码通过
            //获取账号ID
            $UserID = $this->where($where)->getField('aID');

            //记录登录日志
            $loginLog = M("AdminLoginLog");
            $data['adminID'] = $UserID;
            $data['adminLoginTime'] = date('Y-m-d H:i:s');
            $data['adminLoginIP'] = I('server.REMOTE_ADDR/s');
            $loginLog->add($data);

            //session记录账号ID及用户名
            session('admin.usrID', $UserID);
            session('admin.usrName', $UserName);
            session('salesUID', 1);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取普通管理员账号列表
     * @return mixed
     */
    public function getNormalAdminList()
    {
        return $this->where("aName<>'admin'")->field('aID,aName')->select();
    }

    /**
     * 根据ID查找账号用户名
     * @param int $id 账号ID
     * @return bool|mixed
     */
    public function getName($id)
    {
        if (!empty($id)) {
            return $this->where('aID=' . $id)->getField('aName');
        } else {
            return false;
        }
    }

    /**
     * 根据ID更改相应账号的密码
     * @param int $id 账号ID
     * @param string $password 密码
     * @return bool
     */
    public function changePassword($id, $password)
    {
        if (!empty($id) && !empty($password)) {
            //生成密码掩码
            $salt = generatePasswordSalt();
            $data['aSalt'] = $salt;
            //密码混淆处理
            $data['aPassword'] = md5($password . $salt);
            return $this->where('aID=' . $id)->filter('strip_tags')->save($data);
        } else {
            return false;
        }
    }

    /**
     * 根据ID删除对应管理员账号
     * @param int $id 账号ID
     * @return bool|mixed
     */
    public function deleteByID($id)
    {
        if (!empty($id)) {
            return $this->where('aID=' . $id)->delete();
        } else {
            return false;
        }
    }
}