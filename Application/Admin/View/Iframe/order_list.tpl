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
            <div class="modal-body">确定要删除该订单吗？</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnToCancelO">确定</button>
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

<script src="__PUBLIC__/js/layer.js"></script>

<script language="JavaScript">
    var sendOrderID, cancelOrderID;
    function refresh() {
        var table = $("#orderList");
        $("#orderListT").empty();
        $.getJSON("{{U('Admin/Order/getList')}}", function (data) {
            $.each(data, function (i, item) {
                var orderID = item.orderid;
                var isPaid = item.orderpaid;
                var isPaidW = '';
                var PaidBy = '';
                var orderStatus = item.orderstatus;
                var statusW = '';

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

                var tableRow =
                    "<tr>" +
                    "<td>" + "<a class='checkOrderInfo' title='查看订单详细信息' data-value='" + orderID + "'>" + orderID + "</a>" + "</td>" +
                    "<td>" + item.ordersumprice + "</td>" +
                    "<td>" + isPaidW + "</td>" +
                    "<td>" + PaidBy + "</td>" +
                    "<td>" + statusW + "</td>" +
                    "<td>" +
                    "<button class='btn btn-xs btn-success btnSend' data-value='" + orderID + "'>订单发货</a>" +
                    "<button class='btn btn-xs btn-danger btnCancel' data-value='" + orderID + "' data-toggle='modal' data-target='#alertCancelOWindow'>取消订单</button>" +
                    "</td>" +
                    "</tr>";

                $("#orderListT").append(tableRow);
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

        $("#orderListT").delegate('.checkOrderInfo', 'click', function () {
            var orderID = $(this).attr('data-value');
            $.ajax({
                url: "{{U('Admin/Order/getCurrentInfo')}}",
                type: 'get',
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
                        "<p>" + "订单总价：￥" + data.ordersumprice + "</p>" +
                        "<p>" + "订单收货人：" + data.ordercname + "</p>" +
                        "<p>" + "收货人联系电话：" + data.orderphone + "</p>" +
                        "<p>" + "快递：" + data.expressname + "</p>" +
                        "<p>" + "运单号：" + data.expressnum + "</p>" +
                        "<p>" + "是否已付款：" + isPaidW + "</p>" +
                        "<p>" + "付款方式：" + PaidBy + "</p>" +
                        "<p>" + "订单状态：" + statusW + "</p>";
                    layer.open({
                        type: 1,
                        title: '用户详细信息',
                        content: info
                    });
                }
            });
        });

        /*$("#userListT").delegate('.btnEdit', 'click', function () {
         editUID = $(this).attr('data-value');
         $.ajax({
         url: "{{U('Admin/User/getCurrentInfo')}}",
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
         url: "{{U('Admin/User/update')}}",
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
         $("#editUserWindow").modal('hide');
         $("#alertHint").modal('show');
         }
         })
         } else {
         $("#alertHintContent").empty().append("请输入用户名！");
         $("#alertHint").modal('show');
         }
         }
         });

         $("#userListT").delegate('.btnDel', 'click', function () {
         delUID = $(this).attr('data-value');
         });

         $("#btnToDelU").click(function () {
         if (delUID != '') {
         $.ajax({
         url: "{{U('Admin/User/delete')}}",
         type: 'post',
         data: {
         userID: delUID
         },
         dataType: 'text',
         success: function (data) {
         if (data == 'true') {
         $("#alertHintContent").empty().append("删除成功！");
         } else if (data == 'false') {
         $("#alertHintContent").empty().append("删除失败！");
         }
         $("#alertDelUWindow").modal('hide');
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
         editUID = '';
         delUID = '';
         refresh();
         break;
         }
         });*/
    })
</script>
</html>
