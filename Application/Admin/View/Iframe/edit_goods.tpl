<!DOCTYPE html>
<html lang="zh">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>编辑商品信息 - 商城后台管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="__PUBLIC__/css/font-awesome.min.css" rel="stylesheet">

    <link href="__PUBLIC__/css/wangEditor.min.css" rel="stylesheet">

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
            <h2 class="page-header">编辑商品信息</h2>
            <form action="{{U('Admin/Goods/update')}}" enctype="multipart/form-data" method="post">
                {{nocache}}
                <input type="hidden" name="goodsID" value="{{$data['gid']}}">
                <div class="form-group">
                    <label for="textGoodsName">商品名称</label>
                    <input type="text" class="form-control" id="textGoodsName" name="goodsName" placeholder="商品名称"
                           value="{{$data['gname']}}"
                           required>
                </div>
                <div class="form-group">
                    <label for="goodsType">商品类型</label>
                    <select class="form-control" id="goodsType" name="goodsType">

                    </select>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-cny fa-fw"></i></span>
                            <input type="text" class="form-control" id="goodsPrice" name="goodsPrice"
                                   placeholder="商品价格" value="{{$data['gprice']}}" required>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-cny fa-fw"></i></span>
                            <input type="text" class="form-control" id="goodsOriginPrice" name="goodsOriginPrice"
                                   value="{{$data['goriginprice']}}"
                                   placeholder="原价">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="input-group">
                            <input type="number" class="form-control" id="goodsCount" name="goodsCount"
                                   value="{{$data['gcount']}}"
                                   placeholder="库存量" required>
                        </div>
                    </div>
                </div>
                <!--<div class="form-group">
                    <label for="goodsDesc">商品图片<span style="color: red;font-weight: bold">（必要）</span></label>
                    <input type="file" name="headerPic">
                </div>-->
                <div class="form-group">
                    <label for="goodsDesc">商品描述</label>
                    <textarea class="form-control" id="goodsDesc" name="goodsDesc" rows="20"
                              cols="60">{{$data['gdescription']}}</textarea>
                </div>
                {{nocache}}
                <button type="submit" class="btn btn-success">提交</button>
                <a href="javascript:history.go(-1)" class="btn btn-default">返回</a>
            </form>
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

<script src="__PUBLIC__/js/wangEditor.min.js"></script>
<script language="JavaScript">
    var goodsTypeID = {{$data['gtype']}};
    $(function () {
        var editor = new wangEditor('goodsDesc');
        editor.config.uploadImgUrl = '{{U('Admin/Goods/uploadImg')}}';
        editor.config.hideLinkImg = true;
        editor.create();

        $.getJSON("{{U('Admin/Goods/getTypeList')}}", function (data) {
            $.each(data, function (i, item) {
                if (goodsTypeID == item.tid) {
                    $("#goodsType").append("<option value='" + item.tid + "' selected>" + item.tname + "</option>");
                } else {
                    $("#goodsType").append("<option value='" + item.tid + "'>" + item.tname + "</option>");
                }
            });
        });
    })
</script>
</html>
