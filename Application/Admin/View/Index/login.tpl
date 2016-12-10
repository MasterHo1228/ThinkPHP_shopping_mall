<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>登录 - 商城后台管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="__PUBLIC__/css/sb-admin-2.min.css" rel="stylesheet">

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
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">登录</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" id="usrName" placeholder="用户名" name="usrName" type="text"
                                       autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="usrPasswd" placeholder="密码" name="usrPasswd"
                                       type="password" required>
                            </div>

                            <div class="form-group" id="divVCode">
                                <p id="captcha-container">
                                    {{nocache}}<img id="captcha_img" width="120" height="40" alt="验证码"
                                                    src="{{U('backyard/Index/MakeVCode')}}" title="点击刷新">{{/nocache}}
                                    <input type="text" class="form-control" id="vCode" name="vCode" placeholder="验证码">
                                    <span id="VCodeError" class="help-block" style="display: none">验证码错误</span>
                                </p>
                            </div>
                            <button type="submit" class="btn btn-lg btn-success btn-block" id="btnLogin" disabled>登录
                            </button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<!-- jQuery -->
<script src="__PUBLIC__/js/jquery.min.js"></script>

<script language="JavaScript">
    var captcha_img = $('#captcha_img');
    function refreshVCode() {
        var verifyImg = captcha_img.prop("src");
        if (verifyImg.indexOf('?') > 0) {
            captcha_img.prop("src", verifyImg + '&random=' + Math.random());
        } else {
            captcha_img.prop("src", verifyImg.replace(/\?.*$/, '') + '?' + Math.random());
        }
    }

    $(function () {
        refreshVCode();
        captcha_img.click(function () {
            refreshVCode();
        });

        $(".form-group>input").blur(function () {
            if ($("#usrName").val() == '' || $("#usrPasswd").val() == '' || $("#vCode").val() == '') {
                $("#btnLogin").prop('disabled', true);
            } else {
                $("#btnLogin").prop('disabled', false);
            }
        });

        $("#vCode").blur(function () {
            var vCode = $(this).val();
            $.ajax({
                url: "{{U('backyard/Index/verifyVCode')}}",
                type: 'post',
                data: {
                    vCode: vCode
                },
                dataType: 'json',
                success: function (data) {
                    if (data.checked == 'true') {
                        $("#divVCode").removeClass('has-error').addClass('has-success');
                        $("#VCodeError").hide();
                        $("#btnLogin").prop('disabled', false);
                    } else if (data.checked == 'false') {
                        $("#VCodeError").show();
                        $("#divVCode").removeClass('has-success').addClass('has-error');
                        $("#btnLogin").prop('disabled', true);
                    }
                }
            })
        });
    })
</script>
</html>
