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
        return $this->field('uID,uName,uGender,uEmail,uPhone')->select();
    }
}