<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="MasterHo1228">
    <title>商城后台管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="__PUBLIC__/css/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="__PUBLIC__/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="__PUBLIC__/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        iframe#mainIframe {
            width: 100%;
            margin: 0 0 1em;
            border: 0;
        }
    </style>

</head>

<body>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{U('Admin/Main/main')}}">商城后台管理系统</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> {{$smarty.session.admin.usrName}} <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{U('Admin/Main/logout')}}"><i class="fa fa-sign-out fa-fw"></i> 登出</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a class="active" href="{{U('Admin/Iframe/welcome')}}" target="mainIframe">欢迎</a>
                    </li>
                    <li>
                        <a href="{{U('Admin/Iframe/goodsList')}}" target="mainIframe"><i
                                    class="fa fa-shopping-basket fa-fw"></i> 商品管理</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" target="mainIframe"><i class="fa fa-list-alt fa-fw"></i> 订单管理</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" target="mainIframe"><i class="fa fa-bullhorn fa-fw"></i> 网站公告管理</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" target="mainIframe"><i class="fa fa-group fa-fw"></i> 账号管理 <span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="javascript:void(0)">商城用户管理</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">店铺账号管理</a>
                            </li>
                            {{if isset($smarty.session.admin)}}
                            <li>
                                <a href="{{U('Admin/Iframe/adminLog')}}" target="mainIframe">系统管理员登录日志</a>
                            </li>
                            {{if $smarty.session.admin.usrName=='admin'}}
                            <li>
                                <a href="{{U('Admin/Iframe/adminList')}}" target="mainIframe">管理员账号管理</a>
                            </li>
                            {{/if}}
                            {{/if}}
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <iframe id="mainIframe" name="mainIframe" src="{{U('Admin/Iframe/welcome')}}" width="100%" height="580"
                onload="this.height=mainIframe.document.body.scrollHeight" frameborder="0"></iframe>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
</body>

<!-- jQuery -->
<script src="__PUBLIC__/js/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="__PUBLIC__/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="__PUBLIC__/js/metisMenu.min.js"></script>

<script src="__PUBLIC__/js/sb-admin-2.min.js"></script>

</html>
