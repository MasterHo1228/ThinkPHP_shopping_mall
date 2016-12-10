<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.08
 * Time: 16:35
 */

namespace Admin\Model;

use Think\Model;

/**
 * 商城用户模型类
 * Class UserModel
 * @package Admin\Model
 */
class UserModel extends Model
{
    //重写表名
    protected $tableName = 'users';

    /**
     * 获取所有用户列表
     * @return mixed
     */
    public function getAllUserList()
    {
        return $this->field('uID,uName')->select();
    }

    /**
     * 根据用户ID获取用户信息
     * @param $id
     * @return bool|mixed
     */
    public function getInfoByID($id)
    {
        if (!empty($id)) {
            return $this->where('uID=' . $id)->field('uID,uName,uGender,uEmail,uPhone')->find();
        } else {
            return false;
        }
    }

    /**
     * 根据用户ID更新用户信息
     * @param int $id 用户ID
     * @param string $name 用户名
     * @param string $password 密码
     * @param string $gender 性别
     * @param string $email E-Mail
     * @param string $phone 联系电话
     * @return bool
     */
    public function updateInfo($id, $name, $password, $gender, $email, $phone)
    {
        if (!empty($id)) {
            $data['uName'] = $name;
            $data['uGender'] = $gender;
            $data['uEmail'] = $email;
            $data['uPhone'] = $phone;
            if (!empty($password)) {
                $data['uPassword'] = md5($password);
            }
            return $this->where('uID=' . $id)->save($data);
        } else {
            return false;
        }
    }

    /**
     * 根据用户ID删除对应账号
     * @param int $id 用户ID
     * @return bool|mixed
     */
    public function deleteByID($id)
    {
        if (!empty($id)) {
            return $this->where('uID=' . $id)->delete();
        } else {
            return false;
        }
    }
}