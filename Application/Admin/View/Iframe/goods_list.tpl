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
                    <div class="panel-title pull-left">商品列表</div>
                    <button class="btn btn-xs btn-default pull-right" id="btnRefresh">刷新</button>
                    <div class="clearfix"></div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <a class="btn btn-primary btn-block" href="{{U('Admin/Iframe/add_goods')}}">添加商品</a>
                    <br/>
                    <table width="100%" class="table table-striped table-bordered table-hover" id="goodsList">
                        <thead>
                        <tr>
                            <th>商品编号</th>
                            <th>商品名称</th>
                            <th>商品种类</th>
                            <th>商品价格</th>
                            <th>商品库存</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="goodsListT">

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
</body>
<!-- jQuery -->
<script src="__PUBLIC__/js/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="__PUBLIC__/js/bootstrap.min.js"></script>

<script src="__PUBLIC__/js/jquery.dataTables.min.js"></script>
<script src="__PUBLIC__/js/dataTables.bootstrap.min.js"></script>
<script src="__PUBLIC__/js/dataTables.responsive.min.js"></script>

<script src="__PUBLIC__/js/wangEditor.min.js"></script>

<script language="JavaScript">
    var table;
    function refresh() {
        $.getJSON("{{U('Admin/Goods/getList')}}", function (data) {
            $("#goodsListT").empty();
            $.each(data, function (i, item) {
                var tableRow =
                    "<tr>" +
                    "<td>" + item.gid + "</td>" +
                    "<td>" + item.gname + "</td>" +
                    "<td>" + item.goodstypename + "</td>" +
                    "<td>" + item.gprice + "</td>" +
                    "<td>" + item.gcount + "</td>" +
                    "<td>" +
                    "<a class='btnInfo' data-value='" + item.gid + "'><i class='fa fa-search fa-fw'></i></a>" +
                    "<a class='btnInfo' href='{{U('Admin/Iframe/editGoods')}}?gID=" + item.gid + "'><i class='fa fa-edit fa-fw'></i></a>" +
                    "<a class='btnRankTop' data-value='" + item.gid + "'><i class='fa fa-arrow-up fa-fw'></i></a>" +
                    "<a class='btnShutdown' data-value='" + item.gid + "'><i class='fa fa-close fa-fw'></i></a>" +
                    "<a class='btnDel' data-value='" + item.gid + "'><i class='fa fa-trash fa-fw'></i></a>" +
                    "</td>" +
                    "</tr>";

                $("#goodsListT").append(tableRow);
            })
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
    }

    $(function () {
        refresh();
    })
</script>
</html>
