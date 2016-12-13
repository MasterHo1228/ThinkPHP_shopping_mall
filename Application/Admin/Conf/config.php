<?php
return array(
    //'配置项'=>'配置值'
    'DEFAULT_CONTROLLER' => 'Index', // 默认控制器名称
    'DEFAULT_ACTION' => 'login', // 默认操作名称

    // 布局设置
    'TMPL_ENGINE_TYPE' => 'smarty',
    //模板文件后缀
    'TMPL_TEMPLATE_SUFFIX' => '.tpl',
    'TMPL_ENGINE_CONFIG' => array(
        'caching' => false,
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