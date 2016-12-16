<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.12
 * Time: 18:23
 */

namespace Home\Model;

use Think\Model;

/**
 * 前台用户模型类
 * Class UserModel
 * @package Home\Model
 */
class UserModel extends Model
{
    //重写数据库表名
    protected $tableName = 'users';

    /**
     * 验证账号
     * @param string $userName 用户名
     * @param string $password 密码
     * @return bool
     */
    public function checkAccount($userName, $password)
    {
        if (!empty($userName) && !empty($password)) {
            $where['uName'] = $userName;
            //获取对应用户的密码及掩码
            $tmpSalt = $this->where($where)->getField('uSalt');
            $tmpPassword = $this->where($where)->getField('uPassword');

            if (md5($tmpSalt . $password) == $tmpPassword) {//输入密码经md5解析后若与数据库数据相符 则通过验证
                //获取用户ID
                $userID = $this->where($where)->getField('uID');
                //往session记录信息
                session('user.usrID', $userID);
                session('user.usrName', $userName);
                return true;
            } else {
                //验证失败
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 添加用户
     * @param string $userName 用户名
     * @param string $password 密码
     * @param string $gender 性别
     * @param string $email E-Mail
     * @param string $phone 联系电话
     * @return bool|mixed
     */
    public function addUser($userName, $password, $gender, $email, $phone)
    {
        if (!empty($userName) && !empty($password)) {
            $data['uName'] = $userName;
            $salt = generatePasswordSalt();
            $data['uSalt'] = $salt;
            $data['uPassword'] = md5($salt . $password);
            $data['uGender'] = $gender;
            $data['uEmail'] = $email;
            $data['uPhone'] = $phone;

            return $this->add($data);
        } else {
            return false;
        }
    }
}