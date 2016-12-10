<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.05
 * Time: 21:39
 */

/**
 * 管理员账户身份验证
 * @return bool
 */
function checkAdminLogin()
{
    if (session('?admin')) {
        return true;
    } else {
        return false;
    }
}

/**
 * 验证是否为真的主管理员 _(:з」∠)_
 * @return bool
 */
function isRealAdmin()
{
    if (session('admin.usrName') == 'admin') {
        return true;
    } else {
        return false;
    }
}

/**
 * 商城店铺账号登录验证
 * @return bool
 */
function checkSalesUserLogin()
{
    if (session('?salesUID')) {
        return true;
    } else {
        return false;
    }
}