<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.12
 * Time: 18:23
 */

namespace Home\Model;

use Think\Model;

class UserModel extends Model
{
    protected $tableName = 'users';

    public function checkAccount($userName, $password)
    {
        if (!empty($userName) && !empty($password)) {
            $where['uName'] = $userName;
            $tmpSalt = $this->where($where)->getField('uSalt');
            $tmpPassword = $this->where($where)->getField('uPassword');

            if (md5($tmpSalt . $password) == $tmpPassword) {
                $userID = $this->where($where)->getField('uID');
                session('user.usrID', $userID);
                session('user.usrName', $userName);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

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