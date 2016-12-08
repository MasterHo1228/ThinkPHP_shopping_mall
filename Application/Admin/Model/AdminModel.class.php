<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 16:23
 */

namespace Admin\Model;

use Think\Model;

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
        $where['aName'] = $UserName;

        $tmp_Password = $this->where($where)->getField('aPassword');
        $tmp_salt = $this->where($where)->getField('aSalt');

        if (md5($Password . $tmp_salt) == $tmp_Password) {
            $UserID = $this->where($where)->getField('aID');

            $loginLog = M("AdminLoginLog");
            $data['adminID'] = $UserID;
            $data['adminLoginTime'] = date('Y-m-d H:i:s');
            $data['adminLoginIP'] = I('server.REMOTE_ADDR/s');
            $loginLog->add($data);

            session('admin.usrID', $UserID);
            session('admin.usrName', $UserName);
            session('salesUID', 1);
            return true;
        } else {
            return false;
        }
    }

    public function getNormalAdminList()
    {
        return $this->where("aName<>'admin'")->field('aID,aName')->select();
    }

    public function getName($id)
    {
        if (!empty($id)) {
            return $this->where('aID=' . $id)->getField('aName');
        } else {
            return false;
        }
    }

    public function changePassword($id, $password)
    {
        if (!empty($id) && !empty($password)) {
            $salt = generatePasswordSalt();
            $data['aPassword'] = md5($password . $salt);
            $data['aSalt'] = $salt;
            return $this->where('aID=' . $id)->save($data);
        } else {
            return false;
        }
    }

    public function deleteByID($id)
    {
        if (!empty($id)) {
            return $this->where('aID=' . $id)->delete();
        } else {
            return false;
        }
    }
}