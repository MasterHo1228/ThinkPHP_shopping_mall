<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 15:58
 */

/**
 * 验证码验证
 * @param string $code 输入验证码
 * @param string $id
 * @return bool
 */
function check_verify($code, $id = "")
{
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**
 * 清除session信息
 * @param string $userType session变量名
 */
function clearSession($userType)
{
    if (!empty($_SESSION) && !empty($userType)) {
        session($userType, null);
    }
}

/**
 * 生成随机4位字符串的密码掩码
 * @return string 生成的密码掩码
 */
function generatePasswordSalt()
{
    //字典
    $chars = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
        "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
        "3", "4", "5", "6", "7", "8", "9"
    );
    $charsLen = count($chars) - 1;
    shuffle($chars); // 将数组打乱

    $output = "";
    for ($i = 0; $i < 4; $i++) {
        $output .= $chars[mt_rand(0, $charsLen)];
    }

    return $output;
}

function generateOrderNum()
{
    $prefix = "MG";
    $nowTime = date("YmdHis", time());
    $randNum = rand(100000, 999999);

    $orderNum = $prefix . $nowTime . $randNum;
    return $orderNum;
}