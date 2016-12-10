<!DOCTYPE html>
<html lang="zh">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>欢迎 - 商城后台管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            {{nocache}}
            <h1 class="page-header">
                {{if isset($smarty.session.admin)}}
                Welcome!
                <small>{{$smarty.session.admin.usrName}}</small>
                {{elseif isset($smarty.session.salesUName)}}
                欢迎!
                <small>{{$smarty.session.salesUName}}</small>
                {{/if}}
            </h1>
            <p>
                {{if isset($smarty.session.admin)}}
                {{if isset($loginTime)}}
                上次登录时间:{{$loginTime}}
                {{else}}
                您是第一次登入系统~
                {{/if}}
            </p>
            <p>
                {{if isset($loginIpAddr)}}
                上次登录的IP地址:{{$loginIpAddr}}
                {{/if}}
            </p>
            {{/if}}
            {{/nocache}}
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->

</body>
</html>
