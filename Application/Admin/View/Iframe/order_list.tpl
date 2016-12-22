<!DOCTYPE html>
<html lang="zh">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>订单列表 - 商城后台管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="__PUBLIC__/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="__PUBLIC__/css/responsive.bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
        .checkOrderInfo {
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
                    <div class="panel-title pull-left">订单列表</div>
                    <button class="btn btn-xs btn-default pull-right" id="btnRefresh">刷新</button>
                    <div class="clearfix"></div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="orderList">
                        <thead>
                        <tr>
                            <th>订单号</th>
                            <th>用户名</th>
                            <th>订单价格</th>
                            <th>是否已支付</th>
                            <th>支付方式</th>
                            <th>订单状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="orderListT">

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>订单号</th>
                            <th>用户名</th>
                            <th>订单价格</th>
                            <th>是否已支付</th>
                            <th>支付方式</th>
                            <th>订单状态</th>
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

<!-- 订单发货窗口 -->
<div class="modal fade" id="editOrderWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">订单信息编辑</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="editOrderID">订单号</label>
                    <input type="text" class="form-control" id="editOrderID" name="editOrderID" readonly>
                </div>
                <div class="form-group">
                    <label for="editOrderCName">订单收货人</label>
                    <input type="text" class="form-control" id="editOrderCName" name="editOrderCName">
                </div>
                <div class="form-group">
                    <label for="editOrderAddress">收货地址</label>
                    <input type="text" class="form-control" id="editOrderAddress" name="editOrderAddress">
                </div>
                <div class="form-group">
                    <label for="editOrderPhone">联系电话</label>
                    <input type="text" class="form-control" id="editOrderPhone" name="editOrderPhone">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnToEditOrder">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 订单发货窗口 -->
<div class="modal fade" id="sendOrderWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">订单发货</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="sendOrderID">订单号</label>
                    <input type="text" class="form-control" id="sendOrderID" name="sendOrderID" readonly>
                </div>
                <div class="form-group">
                    <label for="sendOrderCName">订单收货人</label>
                    <input type="text" class="form-control" id="sendOrderCName" name="sendOrderCName" readonly>
                </div>
                <div class="form-group">
                    <label for="sendOrderAddress">收货地址</label>
                    <input type="text" class="form-control" id="sendOrderAddress" name="sendOrderAddress" readonly>
                </div>
                <div class="form-group">
                    <label for="sendOrderPhone">联系电话</label>
                    <input type="text" class="form-control" id="sendOrderPhone" name="sendOrderPhone" readonly>
                </div>
                <div class="form-group">
                    <label for="sendOrderExpress">发货快递</label>
                    <select class="form-control" id="sendOrderExpress" name="sendOrderExpress">
                        <option value="1">顺丰速运</option>
                        <option value="2">申通快递</option>
                        <option value="3">圆通快递</option>
                        <option value="4">中通快递</option>
                        <option value="5">韵达快递</option>
                        <option value="6">EMS</option>
                        <option value="7">百世汇通</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editOrderPhone">快递运单号</label>
                    <input type="text" class="form-control" id="sendOrderEID" name="sendOrderEID" placeholder="快递运单号">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnToSendOrder">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 取消订单提示 -->
<div class="modal fade" id="alertCancelOWindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">取消订单</h4>
            </div>
            <div class="modal-body">确定要取消该订单吗？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnToCancelO">确定</button>
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
            <div class="modal-body" id="alertHintContent"></div>
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
    var editOrderID, sendOrderID, cancelOrderID;
    function refresh() {
        $("#orderListT").empty();
        $.getJSON("{{U('backyard/Order/getList')}}", function (data) {
            $.each(data, function (i, item) {
                var orderID = item.orderid;
                var isPaid = item.orderpaid;
                var isPaidW = '';
                var PaidBy = '';
                var orderStatus = item.orderstatus;
                var statusW = '';
                var editStyle = 'none';
                var statusStyle = 'none';
                var cancelStyle = 'block';

                switch (isPaid) {
                    case '0':
                        isPaidW = '未付款';
                        break;
                    case '1':
                        isPaidW = '已付款';
                        break;
                }
                switch (item.orderpaidby) {
                    case 'alipay':
                        PaidBy = '支付宝';
                        break;
                    case 'wechat':
                        PaidBy = '微信';
                        break;
                }
                switch (orderStatus) {
                    case '0':
                        statusW = '已取消';
                        cancelStyle = 'none';
                        break;
                    case '1':
                        statusW = '未发货';
                        if (isPaid == '1') {
                            editStyle = 'block';
                            statusStyle = 'block';
                        }
                        break;
                    case '2':
                        statusW = '已发货';
                        break;
                    case '3':
                        statusW = '已收货';
                        cancelStyle = 'none';
                        break;
                }

                var tableRow =
                    "<tr>" +
                    "<td>" + "<a class='checkOrderInfo' title='查看订单详细信息' data-value='" + orderID + "'>" + orderID + "</a>" + "</td>" +
                    "<td>" + item.orderusername + "</td>" +
                    "<td>" + item.ordersumprice + "</td>" +
                    "<td>" + isPaidW + "</td>" +
                    "<td>" + PaidBy + "</td>" +
                    "<td>" + statusW + "</td>" +
                    "<td>" +
                    "<button class='btn btn-xs btn-primary btnEdit' style='display: " + editStyle + "' data-value='" + orderID + "'>编辑</a>" +
                    "<button class='btn btn-xs btn-success btnSend' style='display: " + statusStyle + "' data-value='" + orderID + "'>订单发货</a>" +
                    "<button class='btn btn-xs btn-danger btnCancel' style='display: " + cancelStyle + "' data-value='" + orderID + "' data-toggle='modal' data-target='#alertCancelOWindow'>取消订单</button>" +
                    "</td>" +
                    "</tr>";

                $("#orderListT").append(tableRow);
            });
            $("#orderList").dataTable({
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

        $("#orderListT").delegate('.checkOrderInfo', 'click', function () {
            var orderID = $(this).attr('data-value');
            $.ajax({
                url: "{{U('backyard/Order/getCurrentDetailInfo')}}",
                type: 'post',
                data: {
                    orderID: orderID
                },
                dataType: 'json',
                success: function (data) {
                    var isPaid = data.orderpaid;
                    var isPaidW = '';
                    var PaidBy = '';
                    var orderStatus = data.orderstatus;
                    var statusW = '';

                    switch (isPaid) {
                        case '0':
                            isPaidW = '未付款';
                            break;
                        case '1':
                            isPaidW = '已付款';
                            break;
                    }
                    switch (data.orderpaidby) {
                        case 'alipay':
                            PaidBy = '支付宝';
                            break;
                        case 'wechat':
                            PaidBy = '微信';
                            break;
                    }
                    switch (orderStatus) {
                        case '0':
                            statusW = '已取消';
                            break;
                        case '1':
                            statusW = '未发货';
                            break;
                        case '2':
                            statusW = '已发货';
                            break;
                        case '3':
                            statusW = '已收货';
                            break;
                    }

                    var info =
                        "<p>" + "订单号：" + data.orderid + "</p>" +
                        "<p>" + "用户名：" + data.orderusername + "</p>" +
                        "<p>" + "订单总价：￥" + data.ordersumprice + "</p>" +
                        "<p>" + "是否已付款：" + isPaidW + "</p>" +
                        "<p>" + "付款方式：" + PaidBy + "</p>" +
                        "<p>" + "订单状态：" + statusW + "</p>" +
                        "<p>" + "订单收货人：" + data.ordercname + "</p>" +
                        "<p>" + "收货地址：" + data.orderaddress + "</p>" +
                        "<p>" + "收货人联系电话：" + data.orderphone + "</p>" +
                        "<p>" + "快递：" + data.expressname + "</p>" +
                        "<p>" + "运单号：" + data.expressnum + "</p>";


                    info += "<p>订单商品：</p>";
                    info += "<ul style='list-style: none'>";

                    $.each(data.goods, function (i, item) {
                        info += "<li>" + "商品名：" + item.goodsname + " " + "商品单价：" + item.goodsprice + " " + "商品数量：" + item.goodscount + "</li>";
                    });

                    info += "</ul>";

                    layer.open({
                        type: 1,
                        title: '用户详细信息',
                        content: info
                    });
                },
                error: function () {
                    showAlertDialog('无法查询订单信息！')
                }
            });
        });

        $("#orderListT").delegate('.btnEdit', 'click', function () {
            editOrderID = $(this).attr('data-value');
            $.ajax({
                url: "{{U('backyard/Order/getCurrentSimpleInfo')}}",
                type: 'post',
                data: {
                    orderID: editOrderID
                },
                dataType: 'json',
                success: function (data) {
                    $("#editOrderID").val(sendOrderID);
                    $("#editOrderCName").val(data.ordercname);
                    $("#editOrderAddress").val(data.orderaddress);
                    $("#editOrderPhone").val(data.orderphone);
                },
                complete: function () {
                    $("#editOrderWindow").modal('show');
                }
            });
        });

        $("#orderListT").delegate('.btnSend', 'click', function () {
            sendOrderID = $(this).attr('data-value');
            $.ajax({
                url: "{{U('backyard/Order/getCurrentSimpleInfo')}}",
                type: 'post',
                data: {
                    orderID: sendOrderID
                },
                dataType: 'json',
                success: function (data) {
                    $("#sendOrderID").val(sendOrderID);
                    $("#sendOrderCName").val(data.ordercname);
                    $("#sendOrderAddress").val(data.orderaddress);
                    $("#sendOrderPhone").val(data.orderphone);
                },
                complete: function () {
                    $("#sendOrderWindow").modal('show');
                }
            });
        });

        $("#btnToEditOrder").click(function () {
            if (editOrderID != '') {
                var orderCName = $("#editOrderCName").val();
                var orderAddress = $("#editOrderAddress").val();
                var orderPhone = $("#editOrderPhone").val();

                if (orderCName != '' && orderAddress != '' && orderPhone != '') {
                    $.ajax({
                        url: "{{U('backyard/Order/edit')}}",
                        type: 'post',
                        data: {
                            orderID: editOrderID,
                            orderCName: orderCName,
                            orderAddress: orderAddress,
                            orderPhone: orderPhone
                        },
                        dataType: 'text',
                        success: function (data) {
                            $("#editOrderWindow").modal('hide');
                            if (data == 'true') {
                                $("#editOrderCName").val('');
                                $("#editOrderAddress").val('');
                                $("#editOrderPhone").val('');

                                showAlertDialog('已更新订单信息！', 'refresh');
                            } else if (data == 'false') {
                                showAlertDialog('操作失败！', 'refresh');
                            }
                        }
                    })
                } else {
                    showAlertDialog('订单收货信息请填写完整！');
                }
            }
        });

        $("#btnToSendOrder").click(function () {
            if (sendOrderID != '') {
                var sendOrderExpress = $("#sendOrderExpress").val();
                var sendOrderEID = $("#sendOrderEID").val();
                if (sendOrderExpress != '' && sendOrderEID != '') {
                    $.ajax({
                        url: "{{U('backyard/Order/send')}}",
                        type: 'post',
                        data: {
                            orderID: sendOrderID,
                            expressID: sendOrderExpress,
                            expressNum: sendOrderEID
                        },
                        dadaType: 'text',
                        success: function (data) {
                            $("#sendOrderWindow").modal('hide');
                            if (data == 'true') {
                                $("#sendOrderExpress").val('');
                                $("#sendOrderEID").val('');
                                showAlertDialog('已更新订单物流信息，发货成功！', 'refresh');
                            } else if (data == 'false') {
                                showAlertDialog('操作失败！', 'refresh');
                            }
                        }
                    })
                } else {
                    showAlertDialog('快递信息请填写完整！');
                }
            }
        });

        $("#orderListT").delegate('.btnCancel', 'click', function () {
            cancelOrderID = $(this).attr('data-value');
        });

        $("#btnToCancelO").click(function () {
            if (cancelOrderID != '') {
                $.ajax({
                    url: "{{U('backyard/Order/cancel')}}",
                    type: 'post',
                    data: {
                        orderID: cancelOrderID
                    },
                    dataType: 'text',
                    success: function (data) {
                        $("#alertCancelOWindow").modal('hide');
                        if (data == 'true') {
                            showAlertDialog('取消成功！', 'refresh');
                        } else if (data == 'false') {
                            showAlertDialog('操作失败！', 'refresh');
                        }
                    },
                    error: function () {
                        showAlertDialog('操作失败！', 'refresh');
                    }
                });
            }
        });

        $("#btnReload").click(function () {
            $("#alertDialog").modal('hide');

            switch ($(this).attr('value')) {
                case 'refresh':
                    sendOrderID = '';
                    cancelOrderID = '';
                    refresh();
                    break;
            }
        });
    })
</script>
</html>
