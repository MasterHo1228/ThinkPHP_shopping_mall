<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.08
 * Time: 16:35
 */

namespace Admin\Model;

use Think\Model;

class UserModel extends Model
{
    protected $tableName = 'users';

    public function getAllUserList()
    {
        return $this->field('uID,uName')->select();
    }

    public function getInfoByID($id)
    {
        if (!empty($id)) {
            return $this->where('uID=' . $id)->field('uID,uName,uGender,uEmail,uPhone')->find();
        } else {
            return false;
        }
    }

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

    public function deleteByID($id)
    {
        if (!empty($id)) {
            return $this->where('uID=' . $id)->delete();
        } else {
            return false;
        }
    }
}