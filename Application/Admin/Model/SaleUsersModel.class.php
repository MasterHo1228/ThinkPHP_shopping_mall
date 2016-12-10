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
 * 商城店铺账号模型类
 * Class SaleUsersModel
 * @package Admin\Model
 */
class SaleUsersModel extends Model
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
        $where['sName'] = $UserName;

        //获取相应账号的密码及掩码
        $tmp_Password = $this->where($where)->getField('sPassword');
        $tmp_salt = $this->where($where)->getField('sSalt');

        if (md5($Password . $tmp_salt) == $tmp_Password) {//验证密码通过
            //获取账号ID及用户名
            $UserID = $this->where($where)->getField('sID');
            $UserName = $this->where($where)->getField('shopName');

            //session记录账号ID及用户名
            session('salesUID', $UserID);
            session('salesUName', $UserName);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取所有商铺账号列表
     * @return mixed
     */
    public function getAllShopList()
    {
        return $this->field('sID,sName,shopName')->select();
    }

    /**
     * 根据账号ID获取商铺账号信息
     * @param int $id 商铺账号ID
     * @return bool|mixed
     */
    public function getInfoByID($id)
    {
        if (!empty($id)) {
            return $this->where('sID=' . $id)->field('sID,sName,shopName')->find();
        } else {
            return false;
        }
    }

    /**
     * 添加商铺
     * @param string $loginName
     * @param string $password
     * @param string $shopName
     * @return bool|mixed
     */
    public function addShop($loginName, $password, $shopName)
    {
        if (!empty($loginName) && !empty($password) && !empty($shopName)) {
            $data['sName'] = $loginName;
            $data['shopName'] = $shopName;
            //生成密码掩码
            $salt = generatePasswordSalt();
            $data['salt'] = $salt;
            //密码混淆处理
            $data['sPassword'] = md5($password . $salt);

            return $this->add($data);
        } else {
            return false;
        }
    }

    /**
     * 根据账号ID更新商铺账号信息
     * @param int $id 账号ID
     * @param string $name 登录名
     * @param string $password 密码
     * @param string $shopName 商铺名称
     * @return bool
     */
    public function updateInfo($id, $name, $password, $shopName)
    {
        if (!empty($id)) {
            $data['sName'] = $name;
            $data['shopName'] = $shopName;
            if (!empty($password)) {
                //生成密码掩码
                $salt = generatePasswordSalt();
                $data['sSalt'] = $salt;
                //密码混淆处理
                $data['sPassword'] = md5($password . $salt);
            }
            return $this->where('sID=' . $id)->save($data);
        } else {
            return false;
        }
    }

    /**
     * 根据账号ID删除商铺账号
     * @param int $id 账号ID
     * @return bool|mixed
     */
    public function deleteByID($id)
    {
        if (!empty($id)) {
            return $this->where('sID=' . $id)->delete();
        } else {
            return false;
        }
    }
}