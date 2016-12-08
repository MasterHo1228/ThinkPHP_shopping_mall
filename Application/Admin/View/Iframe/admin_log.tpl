<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>管理员登录日志 - 商城后台管理系统</title>
    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="page-header">管理员登录日志</h2>
            <table width="100%" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <td>管理员账号</td>
                    <td>登录时间</td>
                    <td>登录IP地址</td>
                </tr>
                </thead>
                <tbody>
                {{nocache}}
                {{foreach $data as $v}}
                <tr>
                    <td>{{$v['adminname']}}</td>
                    <td>{{$v['adminlogintime']}}</td>
                    <td>{{$v['adminloginip']}}</td>
                </tr>
                {{/foreach}}
                {{/nocache}}
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>