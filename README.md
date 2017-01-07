# ThinkPHP_shopping_mall
A web shopping mall powered by ThinkPHP.

这是一个基于ThinkPHP框架+Bootstrap+Smarty（后台）开发的购物网站。

##网站部署
1.首先，需要在Navicat、phpMyAdmin等的数据库管理工具导入data.sql文件即可部署网站的数据库。

2.接着，在网站根目录中的index.php里，需要根据实际的部署环境，修改入口文件的以下代码（以下常量的值仅供参考）：
>//网站URL（主要看实际部署的环境来设置）
 define('URL', 'http://localhost/test/tp_shopping_mall');
 //定义上传文件目录
 define('UPLOAD_PATH', '/Public/uploads/');
 //定义商品图绝对路径前缀
 define('DEFAULT_HEADER_PIC_PATH', URL . UPLOAD_PATH . 'header/');
 
3.启用服务器端Apache的rewrite模块（详细操作方法请使用搜索引擎查找），并且确认网站根目录是否有.htaccess文件，若均具备以上条件，则跳过此步；若使用nginx，请在nginx中的网站配置文件添加rewrite方法（详情看ThinkPHP官网的完全开发手册）

##后台系统访问
在浏览器地址栏中输入：http://sample.app/backyard 即可访问后台系统（sample.app替换为实际的域名或IP）

后台管理员账号：admin
密码:123456..

##P.S
若在使用过程中发现问题，可以直接在repo中报issue，Thanks~~!

_(:з」∠)_

###特别鸣谢
Design:JC Wang