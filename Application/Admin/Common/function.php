<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.05
 * Time: 21:39
 */

function checkLogin()
{
    if (session('?admin')) {
        return true;
    } else {
        return false;
    }
}