<?php
return array(
    //'配置项'=>'配置值'
    // 允许访问的模块列表
    'MODULE_ALLOW_LIST' => array('Home', 'backyard'),
    // 设置禁止访问的模块列表
    'MODULE_DENY_LIST' => array('Common', 'Runtime'),
    //模块映射
    'URL_MODULE_MAP' => array('backyard' => 'Admin'),

    'DEFAULT_MODULE' => 'Home',  // 默认模块
    'DEFAULT_CONTROLLER' => 'Index', // 默认控制器名称
    'DEFAULT_ACTION' => 'index', // 默认操作名称

    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'dbMall', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => '', // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_CHARSET' => 'utf8mb4', // 数据库编码默认采用utf8mb4

    'URL_MODEL' => 2, // URL访问模式,

    'DATA_CACHE_TIME' => 30,      // 数据缓存有效期 0表示永久缓存
);