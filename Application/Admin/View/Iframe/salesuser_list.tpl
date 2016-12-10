<!DOCTYPE html>
<html lang="zh">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>商城店铺列表 - 商城后台管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="__PUBLIC__/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="__PUBLIC__/css/responsive.bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
        .checkShopInfo {
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
                    <div class="panel-title pull-left">商城店铺列表</div>
                    <button class="btn btn-xs btn-default pull-right" id="btnRefresh">刷新</button>
                    <div class="clearfix"></div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addShopWindow">
                        添加商铺
                    </button>
                    <br/>
                    <table width="100%" class="table table-striped table-bordered table-hover" id="shopList">
                        <thead>
                        <tr>
                            <th>商铺ID</th>
                            <th>商铺名称</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="shopListT">

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>商铺ID</th>
                            <th>商铺名称</th>
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

<!-- 添加商铺提示 -->
<div class="modal fade" id="addShopWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">添加商铺</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="addSUName">商铺名称</label>
                    <input type="email" class="form-control" id="addSUName" name="addSUName"
                           placeholder="商铺名称">
                </div>
                <div class="form-group">
                    <label for="addSULoginName">商铺登录名</label>
                    <input type="text" class="form-control" id="addSULoginName" name="addSULoginName"
                           placeholder="输入商城登录名">
                </div>
                <div class="form-group">
                    <label for="addSUPassword">密码</label>
                    <input type="password" class="form-control" id="addSUPassword" name="addSUPassword"
                           placeholder="输入密码">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnToAddSU">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 编辑商铺提示 -->
<div class="modal fade" id="editShopWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">编辑商铺信息</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="editSUName">商铺名称</label>
                    <input type="email" class="form-control" id="editSUName" name="editSUName"
                           placeholder="商铺名称">
                </div>
                <div class="form-group">
                    <label for="editSULoginName">商铺登录名</label>
                    <input type="text" class="form-control" id="editSULoginName" name="editSULoginName"
                           placeholder="输入商城登录名">
                </div>
                <div class="form-group">
                    <label for="editSUPassword">密码</label>
                    <input type="password" class="form-control" id="editSUPassword" name="editSUPassword"
                           placeholder="输入密码">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnToEditSU">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 删除商铺提示 -->
<div class="modal fade" id="alertDelSUWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">删除商铺</h4>
            </div>
            <div class="modal-body">确定要删除该商铺吗？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnToDelSU">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
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

<script src="__PUBLIC__/js/jquery.dataTables.min.js"></script>
<script src="__PUBLIC__/js/dataTables.bootstrap.min.js"></script>
<script src="__PUBLIC__/js/dataTables.responsive.min.js"></script>

<script language="JavaScript">
    var editSUID, delSUID;
    function refresh() {
        var table = $("#shopList");
        $("#shopListT").empty();
        $.getJSON("{{U('Admin/SaleUsers/getList')}}", function (data) {
            $.each(data, function (i, item) {
                var tableRow =
                    "<tr>" +
                    "<td>" + item.sid + "</td>" +
                    "<td>" + item.shopname + "</td>" +
                    "<td>" +
                    "<button class='btn btn-xs btn-primary btnEdit' data-value='" + item.sid + "'>编辑</a>" +
                    "<button class='btn btn-xs btn-danger btnDel' title='删除' data-value='" + item.sid + "' data-toggle='modal' data-target='#alertDelSUWindow'>删除</button>" +
                    "</td>" +
                    "</tr>";

                $("#shopListT").append(tableRow);
            });
            table.dataTable({
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

        $("#btnToAddSU").click(function () {
            var SULoginName = $("#addSULoginName").val();
            var SUPasswd = $("#addSUPassword").val();
            var SUName = $("#addSUName").val();

            if (SULoginName != '' && SUPasswd != '' && SUName != '') {
                $.ajax({
                    url: "{{U('Admin/SaleUsers/add')}}",
                    type: 'post',
                    data: {
                        SULoginName: SULoginName,
                        SUPasswd: SUPasswd,
                        SUName: SUName
                    },
                    dadaType: 'text',
                    success: function (data) {
                        if (data == 'true') {
                            $("#btnReload").attr('value', 'refresh');
                            $("#alertHintContent").empty().append("商铺添加成功！");
                            $("#addSULoginName").val('');
                            $("#addSUPassword").val('');
                            $("#addSUName").val('');
                        } else if (data == 'false') {
                            $("#alertHintContent").empty().append("商铺添加失败！");
                        }
                        $("#addShopWindow").modal('hide');
                        $("#alertHint").modal('show');
                    }
                })
            } else {
                $("#alertHintContent").empty().append("商铺信息请填写完整！");
                $("#alertHint").modal('show');
            }
        });

        $("#shopListT").delegate('.btnEdit', 'click', function () {
            editSUID = $(this).attr('data-value');
            $.ajax({
                url: "{{U('Admin/SaleUsers/getCurrentInfo')}}",
                type: 'post',
                data: {
                    salesUID: editSUID
                },
                dataType: 'json',
                success: function (data) {
                    $("#editSULoginName").val(data.sname);
                    $("#editSUName").val(data.shopname);
                },
                complete: function () {
                    $("#editShopWindow").modal('show');
                }
            });
        });

        $("#btnToEditSU").click(function () {
            if (editSUID != '') {
                var SULoginName = $("#editSULoginName").val();
                var SUPasswd = $("#editSUPassword").val();
                var SUName = $("#editSUName").val();

                var data;
                if (SULoginName != '' && SUName != '') {
                    if (SUPasswd == '') {
                        data = {
                            salesUID: editSUID,
                            SULoginName: SULoginName,
                            SUName: SUName
                        };
                    } else {
                        data = {
                            salesUID: editSUID,
                            SULoginName: SULoginName,
                            SUPasswd: SUPasswd,
                            SUName: SUName
                        };
                    }

                    $.ajax({
                        url: "{{U('Admin/SaleUsers/update')}}",
                        type: 'post',
                        data: data,
                        dadaType: 'text',
                        success: function (data) {
                            if (data == 'true') {
                                $("#btnReload").attr('value', 'refresh');
                                $("#alertHintContent").empty().append("用户信息更新成功！");
                            } else if (data == 'false') {
                                $("#alertHintContent").empty().append("用户信息更新失败！");
                            }
                            $("#editShopWindow").modal('hide');
                            $("#alertHint").modal('show');
                        }
                    })
                } else {
                    $("#alertHintContent").empty().append("请输入用户名！");
                    $("#alertHint").modal('show');
                }
            }
        });

        $("#shopListT").delegate('.btnDel', 'click', function () {
            delSUID = $(this).attr('data-value');
        });

        $("#btnToDelSU").click(function () {
            if (delSUID != '') {
                $.ajax({
                    url: "{{U('Admin/SaleUsers/delete')}}",
                    type: 'post',
                    data: {
                        salesUID: delSUID
                    },
                    dataType: 'text',
                    success: function (data) {
                        if (data == 'true') {
                            $("#alertHintContent").empty().append("删除成功！");
                        } else if (data == 'false') {
                            $("#alertHintContent").empty().append("删除失败！");
                        }
                        $("#alertDelSUWindow").modal('hide');
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
                    editSUID = '';
                    delSUID = '';
                    refresh();
                    break;
            }
        });
    })
</script>
</html>
