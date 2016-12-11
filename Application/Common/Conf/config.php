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

    'URL_MODEL' => 2, // URL访问模式

    // 布局设置
    'TMPL_ENGINE_TYPE' => 'smarty',
    //模板文件后缀
    'TMPL_TEMPLATE_SUFFIX' => '.tpl',
    'TMPL_ENGINE_CONFIG' => array(
        'caching' => true,
        'compile_dir' => TEMP_PATH,
        'cache_dir' => CACHE_PATH,
        'left_delimiter' => '{{',
        'right_delimiter' => '}}',
    ),

    //默认错误跳转对应的模板文件
    'TMPL_ACTION_ERROR' => 'Tpl/dispatch_jump',
    //默认成功跳转对应的模板文件
    'TMPL_ACTION_SUCCESS' => 'Tpl/dispatch_jump',
);