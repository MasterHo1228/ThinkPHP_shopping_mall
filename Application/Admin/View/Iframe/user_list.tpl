<!DOCTYPE html>
<html lang="zh">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>商城用户列表 - 商城后台管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="__PUBLIC__/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="__PUBLIC__/css/responsive.bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
        .checkUserInfo {
            cursor: pointer;
        }
    </style>

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
                    <div class="panel-title pull-left">用户列表</div>
                    <button class="btn btn-xs btn-default pull-right" id="btnRefresh">刷新</button>
                    <div class="clearfix"></div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="userList">
                        <thead>
                        <tr>
                            <th>用户ID</th>
                            <th>用户名</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="userListT">

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>用户ID</th>
                            <th>用户名</th>
                            <th>操作</th>
                        </tr>
                        </tfoot>
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

<!-- 编辑用户提示 -->
<div class="modal fade" id="editUserWindow" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">编辑用户</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="editUserName">用户名</label>
                    <input type="text" class="form-control" id="editUserName" name="editUserName" placeholder="输入用户名">
                </div>
                <div class="form-group">
                    <label for="editUserPasswd">密码</label>
                    <input type="password" class="form-control" id="editUserPasswd" name="editUserPasswd"
                           placeholder="输入密码">
                </div>
                <div class="form-group">
                    <label for="editUserGender">性别</label>
                    <select class="form-control" id="editUserGender" name="editUserGender">
                        <option value="male">男</option>
                        <option value="female">女</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editUserEmail">E-Mail</label>
                    <input type="email" class="form-control" id="editUserEmail" name="editUserEmail"
                           placeholder="E-Mail">
                </div>
                <div class="form-group">
                    <label for="editUserPhone">联系电话</label>
                    <input type="text" class="form-control" id="editUserPhone" name="editUserPhone" placeholder="联系电话">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnToEditU">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 删除用户提示 -->
<div class="modal fade" id="alertDelUWindow" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">删除用户</h4>
            </div>
            <div class="modal-body">确定要删除该用户吗？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnToDelU">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 自定义提示 -->
<div class="modal fade" id="alertDialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body" id="alertDialogMain"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnReload">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

</body>
<!-- jQuery -->
<script src="__PUBLIC__/js/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="__PUBLIC__/js/bootstrap.min.js"></script>

<script src="__PUBLIC__/js/jquery.dataTables.min.js"></script>
<script src="__PUBLIC__/js/dataTables.bootstrap.min.js"></script>
<script src="__PUBLIC__/js/dataTables.responsive.min.js"></script>

<script src="__PUBLIC__/js/layer.js"></script>

<script src="__PUBLIC__/js/platform.js"></script>

<script language="JavaScript">
    var editUID, delUID;
    function refresh() {
        $("#userListT").empty();
        $.getJSON("{{U('backyard/User/getList')}}", function (data) {
            $.each(data, function (i, item) {
                var tableRow =
                    "<tr>" +
                    "<td>" + item.uid + "</td>" +
                    "<td>" + "<a class='checkUserInfo' title='查看用户详细信息' data-value='" + item.uid + "'>" + item.uname + "</a>" + "</td>" +
                    "<td>" +
                    "<button class='btn btn-xs btn-primary btnEdit' data-value='" + item.uid + "'>编辑</a>" +
                    "<button class='btn btn-xs btn-danger btnDel' title='删除商品' data-value='" + item.uid + "' data-toggle='modal' data-target='#alertDelUWindow'>删除</button>" +
                    "</td>" +
                    "</tr>";

                $("#userListT").append(tableRow);
            });
            $("#userList").dataTable({
                retrieve: true,
                responsive: true,
                sPaginationType: "full_numbers",
                oLanguage: {
                    sLengthMenu: "每页显示 _MENU_ 条记录",
                    sInfo: "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
                    sInfoEmpty: "没有数据",
                    sInfoFiltered: "(从 _MAX_ 条数据中检索)",
                    sZeroRecords: "没有检索到数据",
                    sSearch: "搜索:",
                    oPaginate: {
                        sFirst: "首页",
                        sPrevious: "前一页",
                        sNext: "后一页",
                        sLast: "尾页"
                    }
                }
            });
        });
    }

    $(function () {
        refresh();

        $("#btnRefresh").click(function () {
            refresh();
        });

        $("#userListT").delegate('.checkUserInfo', 'click', function () {
            var userID = $(this).attr('data-value');
            $.ajax({
                url: "{{U('backyard/User/getCurrentInfo')}}",
                type: 'get',
                data: {
                    userID: userID
                },
                dataType: 'json',
                success: function (data) {
                    var gender = '';
                    switch (data.ugender) {
                        case 'male':
                            gender = '男';
                            break;
                        case 'female':
                            gender = '女';
                            break;
                    }
                    var info =
                        "<p>" + "用户ID：" + data.uid + "</p>" +
                        "<p>" + "用户名：" + data.uname + "</p>" +
                        "<p>" + "性别：" + gender + "</p>" +
                        "<p>" + "E-Mail：" + data.uemail + "</p>" +
                        "<p>" + "联系电话：" + data.uphone + "</p>";
                    layer.open({
                        type: 1,
                        title: '用户详细信息',
                        content: info
                    });
                }
            });
        });

        $("#userListT").delegate('.btnEdit', 'click', function () {
            editUID = $(this).attr('data-value');
            $("#editUserPasswd").val('');
            $.ajax({
                url: "{{U('backyard/User/getCurrentInfo')}}",
                type: 'get',
                data: {
                    userID: editUID
                },
                dataType: 'json',
                success: function (data) {
                    $("#editUserName").val(data.uname);
                    $("#editUserEmail").val(data.uemail);
                    $("#editUserPhone").val(data.uphone);
                    $("#editUserGender option[value='" + data.ugender + "']").prop('selected', true);
                },
                complete: function () {
                    $("#editUserWindow").modal('show');
                }
            });
        });

        $("#btnToEditU").click(function () {
            if (editUID != '') {
                var userName = $("#editUserName").val();
                var userPasswd = $("#editUserPasswd").val();
                var userGender = $("#editUserGender").val();
                var userEmail = $("#editUserEmail").val();
                var userPhone = $("#editUserPhone").val();

                var data;
                if (userName != '') {
                    if (userPasswd == '') {
                        data = {
                            userID: editUID,
                            userName: userName,
                            userGender: userGender,
                            userEmail: userEmail,
                            userPhone: userPhone
                        };
                    } else {
                        data = {
                            userID: editUID,
                            userName: userName,
                            userPasswd: userPasswd,
                            userGender: userGender,
                            userEmail: userEmail,
                            userPhone: userPhone
                        };
                    }

                    $.ajax({
                        url: "{{U('backyard/User/update')}}",
                        type: 'post',
                        data: data,
                        dadaType: 'text',
                        success: function (data) {
                            $("#editUserWindow").modal('hide');
                            if (data == 'true') {
                                showAlertDialog('用户信息更新成功！', 'refresh');
                            } else if (data == 'false') {
                                showAlertDialog('用户信息更新失败！', 'refresh');
                            }

                        }
                    })
                } else {
                    showAlertDialog('请输入用户名！');
                }
            }
        });

        $("#userListT").delegate('.btnDel', 'click', function () {
            delUID = $(this).attr('data-value');
        });

        $("#btnToDelU").click(function () {
            if (delUID != '') {
                $.ajax({
                    url: "{{U('backyard/User/delete')}}",
                    type: 'post',
                    data: {
                        userID: delUID
                    },
                    dataType: 'text',
                    success: function (data) {
                        $("#alertDelUWindow").modal('hide');
                        if (data == 'true') {
                            showAlertDialog('删除成功！', 'refresh');
                        } else if (data == 'false') {
                            showAlertDialog('删除失败！', 'refresh');
                        }
                    }
                });
            }
        });

        $("#btnReload").click(function () {
            $("#alertDialog").modal('hide');

            switch ($(this).attr('value')) {
                case 'refresh':
                    editUID = '';
                    delUID = '';
                    refresh();
                    break;
            }
        });
    })
</script>
</html>
