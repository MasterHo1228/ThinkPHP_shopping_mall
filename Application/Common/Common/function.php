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

function generatePasswordSalt()
{
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