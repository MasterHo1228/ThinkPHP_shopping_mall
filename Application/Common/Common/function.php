<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 15:58
 */

function check_verify($code, $id = "")
{
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

function clearSession($userType)
{
    if (!empty($_SESSION) && !empty($userType)) {
        session($userType, null);
    }
}