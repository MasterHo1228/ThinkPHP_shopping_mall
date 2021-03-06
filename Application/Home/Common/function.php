<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016/12/11
 * Time: 21:08
 */

/**
 * 检测用户是否已登录
 * @return bool
 */
function isUserLogin()
{
    if (session('?user')) {
        return true;
    } else {
        return false;
    }
}

/**
 * 获取当前登录用户的ID
 * @return bool|mixed
 */
function getUserID()
{
    if (session('?user')) {
        return session('user.usrID');
    } else {
        return false;
    }
}