<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.08
 * Time: 16:35
 */

namespace Admin\Model;

use Think\Model;

class SaleUsersModel extends Model
{
    public function getAllShopList()
    {
        return $this->field('sID,sName,shopName')->select();
    }

    public function getInfoByID($id)
    {
        if (!empty($id)) {
            return $this->where('sID=' . $id)->field('sID,sName,shopName')->find();
        } else {
            return false;
        }
    }

    public function addShop($loginName, $password, $shopName)
    {
        if (!empty($loginName) && !empty($password) && !empty($shopName)) {
            $data['sName'] = $loginName;
            $data['shopName'] = $shopName;
            $salt = generatePasswordSalt();
            $data['salt'] = $salt;
            $data['sPassword'] = md5($password . $salt);

            return $this->add($data);
        } else {
            return false;
        }
    }

    public function updateInfo($id, $name, $password, $shopName)
    {
        if (!empty($id)) {
            $data['sName'] = $name;
            $data['shopName'] = $shopName;
            if (!empty($password)) {
                $salt = generatePasswordSalt();
                $data['sSalt'] = $salt;
                $data['sPassword'] = md5($password . $salt);
            }
            return $this->where('sID=' . $id)->save($data);
        } else {
            return false;
        }
    }

    public function deleteByID($id)
    {
        if (!empty($id)) {
            return $this->where('sID=' . $id)->delete();
        } else {
            return false;
        }
    }
}