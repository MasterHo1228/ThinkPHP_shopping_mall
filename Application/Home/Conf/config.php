<?php
return array(//'配置项'=>'配置值'
    // 布局设置
    'TMPL_ENGINE_TYPE' => 'Think',
    'TMPL_LAYOUT_ITEM' => '{__CONTENT__}', // 布局模板的内容替换标识
    'LAYOUT_ON' => true, // 是否启用布局
    'LAYOUT_NAME' => 'layout', // 当前布局名称 默认为layout
    //模板文件后缀
    'TMPL_TEMPLATE_SUFFIX' => '.html',
    'TMPL_ACTION_ERROR' => THINK_PATH . 'Tpl/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS' => THINK_PATH . 'Tpl/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
    'TMPL_EXCEPTION_FILE' => THINK_PATH . 'Tpl/think_exception.tpl',// 异常页面的模板文件
);