<!DOCTYPE html>
<html lang="zh">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>管理员账号列表 - 商城后台管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="__PUBLIC__/css/font-awesome.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="__PUBLIC__/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="__PUBLIC__/css/responsive.bootstrap.min.css" rel="stylesheet">

    <link href="__PUBLIC__/css/wangEditor.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">管理员账号列表</div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <a class="btn btn-primary btn-block" href="javascript:void(0)">添加管理员账号</a>
                    <br/>
                    <table width="100%" class="table table-striped table-bordered table-hover" id="adminList">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="adminListT">

                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->

<!-- 删除账号提示 -->
<div class="modal fade" id="alertDelAdminWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">删除账号</h4>
            </div>
            <div class="modal-body">确定要删除该账号吗？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnToDelAdmin">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 修改密码窗口 -->
<div class="modal fade" id="editAdminWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">修改密码</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="adminName">用户名</label>
                    <input type="text" class="form-control" id="adminName" disabled>
                </div>
                <div class="form-group">
                    <label for="adminPasswd">密码</label>
                    <input type="password" class="form-control" id="adminPasswd" placeholder="密码">
                </div>
                <div class="form-group">
                    <label for="adminPasswdT">确认密码</label>
                    <input type="password" class="form-control" id="adminPasswdT" placeholder="确认密码">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnToEdit">确定</button>
                <button type="button" class="btn btn-default" id="btnExitEdit" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 自定义提示 -->
<div class="modal fade" id="alertHint" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">提示</h4>
            </div>
            <div class="modal-body" id="alertHintContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnReload">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

</body>
<!-- jQuery -->
<script src="__PUBLIC__/js/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="__PUBLIC__/js/bootstrap.min.js"></script>

<script language="JavaScript">
    var editAdminID, delAdminID;
    function refresh() {
        $("#adminListT").empty();
        $.getJSON("{{U('Admin/Admin/getList')}}", function (data) {
            $.each(data, function (i, item) {
                var adminID = item.aid;
                var tableRow =
                    "<tr>" +
                    "<td>" + adminID + "</td>" +
                    "<td>" + item.aname + "</td>" +
                    "<td>" +
                    "<button class='btn btn-xs btn-primary btnEdit' value='" + adminID + "'>修改密码</button>" +
                    "<button class='btn btn-xs btn-danger btnDelAdmin' value='" + adminID + "' data-toggle='modal' data-target='#alertDelAdminWindow'>删除</button>" +
                    "</td>" +
                    "</tr>";

                $("#adminListT").append(tableRow);
            });
        });
    }

    $(function () {
        refresh();

        $("#btnRefresh").click(function () {
            refresh();
        });

        $("#adminListT").delegate('.btnEdit', 'click', function () {
            editAdminID = $(this).prop('value');
            $.ajax({
                url: "{{U('Admin/Admin/ajaxGetName')}}",
                type: 'post',
                data: {
                    adminID: editAdminID
                },
                dataType: 'text',
                success: function (data) {
                    if (data != '') {
                        $("#adminName").val(data);
                    }
                    $("#editAdminWindow").modal('show');
                }
            });
        });

        $("#btnToEdit").click(function () {
            if (editAdminID != '') {
                if ($("#adminPasswd").val() == $("#adminPasswdT").val()) {
                    var password = $("#adminPasswd").val();
                    $.ajax({
                        url: "{{U('Admin/Admin/update')}}",
                        type: 'post',
                        data: {
                            type: 'password',
                            adminID: editAdminID,
                            password: password
                        },
                        dataType: 'text',
                        success: function (data) {
                            if (data == 'true') {
                                $("#alertHintContent").empty().append("修改成功！");
                                $("#adminPasswd").val('');
                                $("#adminPasswdT").val('');
                            } else if (data == 'false') {
                                $("#alertHintContent").empty().append("修改失败！");
                            }
                            $("#editAdminWindow").modal('hide');
                            $("#btnReload").attr('value', 'refresh');
                        }
                    });
                } else {
                    $("#alertHintContent").empty().append("两次输入的密码不一致！");
                }
                $("#alertHint").modal('show');
            }
        });

        $("#adminListT").delegate('.btnDelAdmin', 'click', function () {
            delAdminID = $(this).attr('value');
        });

        $("#btnToDelAdmin").click(function () {
            if (delAdminID != '') {
                $.ajax({
                    url: "{{U('Admin/Admin/delete')}}",
                    type: 'post',
                    data: {
                        adminID: delAdminID
                    },
                    dataType: 'text',
                    success: function (data) {
                        if (data == 'true') {
                            $("#alertHintContent").empty().append("删除成功！");
                        } else if (data == 'false') {
                            $("#alertHintContent").empty().append("删除失败！");
                        }
                        $("#alertDelAdminWindow").modal('hide');
                        $("#btnReload").attr('value', 'refresh');
                        $("#alertHint").modal('show');
                    }
                });
            }
        });


        $("#btnReload").click(function () {
            $("#alertHint").modal('hide');

            switch ($(this).attr('value')) {
                case 'refresh':
                    editAdminID = '';
                    delAdminID = '';
                    refresh();
                    break;
            }
            $(this).attr('value', '');
        });
    })
</script>
</html>
