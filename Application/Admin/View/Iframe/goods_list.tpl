<!DOCTYPE html>
<html lang="zh">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>商品列表 - 商城后台管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="__PUBLIC__/css/font-awesome.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="__PUBLIC__/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="__PUBLIC__/css/responsive.bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
        .tableBtns {
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
                    <div class="panel-title pull-left">商品列表</div>
                    <button class="btn btn-xs btn-default pull-right" id="btnRefresh">刷新</button>
                    <div class="clearfix"></div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <a class="btn btn-primary btn-block" href="{{U('backyard/Iframe/add_goods')}}">添加商品</a>
                    <br/>
                    <table width="100%" class="table table-striped table-bordered table-hover" id="goodsList">
                        <thead>
                        <tr>
                            <th>商品编号</th>
                            <th>商品名称</th>
                            <th>商品种类</th>
                            <th>商品价格</th>
                            <th>商品库存</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="goodsListT">

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>商品编号</th>
                            <th>商品名称</th>
                            <th>商品种类</th>
                            <th>商品价格</th>
                            <th>商品库存</th>
                            <th>状态</th>
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

<!-- 删除商品提示 -->
<div class="modal fade" id="alertDelGWindow" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">删除商品</h4>
            </div>
            <div class="modal-body">确定要删除该商品吗？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnToDelG">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 商品下架提示 -->
<div class="modal fade" id="shutdownGWindow" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">下架商品</h4>
            </div>
            <div class="modal-body">确定要下架该商品吗？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnToShut">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 商品重上架提示 -->
<div class="modal fade" id="returnGWindow" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">重上架商品</h4>
            </div>
            <div class="modal-body">确定要重新上架该商品吗？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnToReturn">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 商品置顶提示 -->
<div class="modal fade" id="topGWindow" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">置顶商品</h4>
            </div>
            <div class="modal-body">确定要置顶该商品吗？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnToTop">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 商品取消置顶提示 -->
<div class="modal fade" id="downGWindow" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">置顶商品</h4>
            </div>
            <div class="modal-body">确定要取消置顶该商品吗？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnToDown">确定</button>
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
    var delGID, shutGID, returnGID, topGID, downGID;
    function refresh() {
        $("#goodsListT").empty();
        $.getJSON("{{U('backyard/Goods/getList')}}", function (data) {
            $.each(data, function (i, item) {
                var tableRow;
                switch (item.gstatus) {
                    case '0':
                        tableRow =
                            "<tr>" +
                            "<td>" + item.gid + "</td>" +
                            "<td>" + item.gname + "</td>" +
                            "<td>" + item.goodstypename + "</td>" +
                            "<td>" + item.gprice + "</td>" +
                            "<td>" + item.gcount + "</td>" +
                            "<td>" + "已下架" + "</td>" +
                            "<td>" +
                            "<a class='btnInfo tableBtns' title='查看详细信息' data-value='" + item.gid + "'><i class='fa fa-search fa-fw'></i></a>" +
                            "<a class='btnEdit tableBtns' title='编辑商品信息' href='{{U('backyard/Iframe/editGoods')}}?goodsID=" + item.gid + "'><i class='fa fa-edit fa-fw'></i></a>" +
                            "<a class='btnReturn tableBtns' title='重上架商品'  data-value='" + item.gid + "' data-toggle='modal' data-target='#returnGWindow'><i class='fa fa-check fa-fw'></i></a>" +
                            "</td>" +
                            "</tr>";
                        break;
                    case '1':
                        tableRow =
                            "<tr>" +
                            "<td>" + item.gid + "</td>" +
                            "<td>" + item.gname + "</td>" +
                            "<td>" + item.goodstypename + "</td>" +
                            "<td>" + item.gprice + "</td>" +
                            "<td>" + item.gcount + "</td>" +
                            "<td>" + "正常" + "</td>" +
                            "<td>" +
                            "<a class='btnInfo tableBtns' title='查看详细信息' data-value='" + item.gid + "'><i class='fa fa-search fa-fw'></i></a>" +
                            "<a class='btnEdit tableBtns' title='编辑商品信息' href='{{U('backyard/Iframe/editGoods')}}?goodsID=" + item.gid + "'><i class='fa fa-edit fa-fw'></i></a>" +
                            "<a class='btnRankTop tableBtns' title='商品置顶显示' data-value='" + item.gid + "' data-toggle='modal' data-target='#topGWindow'><i class='fa fa-arrow-up fa-fw'></i></a>" +
                            "<a class='btnShutdown tableBtns' title='下架商品'  data-value='" + item.gid + "' data-toggle='modal' data-target='#shutdownGWindow'><i class='fa fa-close fa-fw'></i></a>" +
                            "</td>" +
                            "</tr>";
                        break;
                    case '2':
                        tableRow =
                            "<tr>" +
                            "<td>" + item.gid + "</td>" +
                            "<td>" + item.gname + "</td>" +
                            "<td>" + item.goodstypename + "</td>" +
                            "<td>" + item.gprice + "</td>" +
                            "<td>" + item.gcount + "</td>" +
                            "<td>" + "置顶" + "</td>" +
                            "<td>" +
                            "<a class='btnInfo tableBtns' title='查看详细信息' data-value='" + item.gid + "'><i class='fa fa-search fa-fw'></i></a>" +
                            "<a class='btnEdit tableBtns' title='编辑商品信息' href='{{U('backyard/Iframe/editGoods')}}?goodsID=" + item.gid + "'><i class='fa fa-edit fa-fw'></i></a>" +
                            "<a class='btnRankDown tableBtns' title='取消置顶' data-value='" + item.gid + "' data-toggle='modal' data-target='#downGWindow'><i class='fa fa-arrow-down fa-fw'></i></a>" +
                            "<a class='btnShutdown tableBtns' title='下架商品'  data-value='" + item.gid + "' data-toggle='modal' data-target='#shutdownGWindow'><i class='fa fa-close fa-fw'></i></a>" +
                            "</td>" +
                            "</tr>";
                        break;
                }

                $("#goodsListT").append(tableRow);
            });
            $("#goodsList").dataTable({
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

        $("#goodsListT").delegate('.btnInfo', 'click', function () {
            var goodsID = $(this).attr('data-value');
            $.ajax({
                url: "{{U('backyard/Goods/getCurrentInfo')}}",
                type: 'get',
                data: {
                    goodsID: goodsID
                },
                dataType: 'json',
                success: function (data) {
                    var status = '';
                    switch (data.gstatus) {
                        case '0':
                            status = '下架';
                            break;
                        case '1':
                            status = '正常';
                            break;
                        case '2':
                            status = '置顶';
                            break;
                    }
                    var info =
                        "<p>" + "商品ID：" + data.gid + "</p>" +
                        "<p>" + "名称：" + data.gname + "</p>" +
                        "<p>" + "<img src='" + data.gphoto + "' width='150' height='150'>" + "</p>" +
                        "<p>" + "种类：" + data.goodstypename + "</p>" +
                        "<p>" + "价格：￥" + data.gprice + "</p>" +
                        "<p>" + "原价：￥" + data.goriginprice + "</p>" +
                        "<p>" + "销量：" + data.gsoldoutnum + "</p>" +
                        "<p>" + "库存：" + data.gcount + "</p>" +
                        "<p>" + "销售商家：" + data.shopname + "</p>" +
                        "<p>" + "商品描述：" + data.gdescription + "</p>" +
                        "<p>" + "上架时间：" + data.gpubtime + "</p>" +
                        "<p>" + "状态：" + status + "</p>";
                    layer.open({
                        type: 1,
                        title: '商品详细信息',
                        content: info
                    });
                }
            });
        });

        $("#goodsListT").delegate('.btnDel', 'click', function () {
            delGID = $(this).attr('data-value');
        });
        $("#goodsListT").delegate('.btnShutdown', 'click', function () {
            shutGID = $(this).attr('data-value');
        });
        $("#goodsListT").delegate('.btnReturn', 'click', function () {
            returnGID = $(this).attr('data-value');
        });
        $("#goodsListT").delegate('.btnRankTop', 'click', function () {
            topGID = $(this).attr('data-value');
        });
        $("#goodsListT").delegate('.btnRankDown', 'click', function () {
            downGID = $(this).attr('data-value');
        });

        $("#btnToShut").click(function () {
            if (shutGID != '') {
                $.ajax({
                    url: "{{U('backyard/Goods/shutdown')}}",
                    type: 'post',
                    data: {
                        goodsID: shutGID
                    },
                    dataType: 'text',
                    success: function (data) {
                        $("#shutdownGWindow").modal('hide');
                        if (data == 'true') {
                            showAlertDialog('商品已下架！', 'refresh');
                        } else if (data == 'false') {
                            showAlertDialog('操作失败！', 'refresh');
                        }
                    }
                });
            }
        });

        $("#btnToReturn").click(function () {
            if (returnGID != '') {
                $.ajax({
                    url: "{{U('backyard/Goods/goodsReturn')}}",
                    type: 'post',
                    data: {
                        goodsID: returnGID
                    },
                    dataType: 'text',
                    success: function (data) {
                        $("#returnGWindow").modal('hide');
                        if (data == 'true') {
                            $("#alertHintContent").empty().append("商品已重上架！");
                            showAlertDialog('商品已重上架！', 'refresh');
                        } else if (data == 'false') {
                            showAlertDialog('操作失败！', 'refresh');
                        }
                    }
                });
            }
        });

        $("#btnToTop").click(function () {
            if (topGID != '') {
                $.ajax({
                    url: "{{U('backyard/Goods/rankTop')}}",
                    type: 'post',
                    data: {
                        goodsID: topGID
                    },
                    dataType: 'text',
                    success: function (data) {
                        $("#topGWindow").modal('hide');
                        if (data == 'true') {
                            showAlertDialog('商品置顶成功！', 'refresh');
                        } else if (data == 'false') {
                            showAlertDialog('操作失败！', 'refresh');
                        }
                    }
                });
            }
        });

        $("#btnToDown").click(function () {
            if (downGID != '') {
                $.ajax({
                    url: "{{U('backyard/Goods/rankDown')}}",
                    type: 'post',
                    data: {
                        goodsID: downGID
                    },
                    dataType: 'text',
                    success: function (data) {
                        $("#downGWindow").modal('hide');
                        if (data == 'true') {
                            showAlertDialog('商品取消置顶成功！', 'refresh');
                        } else if (data == 'false') {
                            showAlertDialog('操作失败！', 'refresh');
                        }
                    }
                });
            }
        });

        $("#btnReload").click(function () {
            $("#alertDialog").modal('hide');

            switch ($(this).attr('value')) {
                case 'reload':
                    window.location.reload();
                    break;
                case 'refresh':
                    delGID = '';
                    shutGID = '';
                    refresh();
                    break;
            }
        });
    })
</script>
</html>
