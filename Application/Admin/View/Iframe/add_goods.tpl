<!DOCTYPE html>
<html lang="zh">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>添加商品 - 商城后台管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="__PUBLIC__/css/font-awesome.min.css" rel="stylesheet">

    <link href="__PUBLIC__/css/wangEditor.min.css" rel="stylesheet">
    <link href="__PUBLIC__/css/cropper.min.css" rel="stylesheet">
    <link href="__PUBLIC__/css/sitelogo.css" rel="stylesheet">

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
            <h2 class="page-header">添加商品</h2>
            <form action="{{U('backyard/Goods/add')}}" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label for="textGoodsName">商品名称</label>
                    <input type="text" class="form-control" id="textGoodsName" name="goodsName" placeholder="商品名称"
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
                                   placeholder="商品价格" required>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-cny fa-fw"></i></span>
                            <input type="text" class="form-control" id="goodsOriginPrice" name="goodsOriginPrice"
                                   placeholder="原价">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="input-group">
                            <input type="number" class="form-control" id="goodsCount" name="goodsCount"
                                   placeholder="库存量" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="goodsDesc">商品图片</label>
                    <div class="ibox-content">
                        <div class="row">
                            <div id="crop-avatar" class="col-md-6">
                                <div class="avatar-view" title="更换商品图片">
                                    <img src="__PUBLIC__/uploads/header/default.jpg" alt="商品图片">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="goodsDesc">商品描述</label>
                    <textarea class="form-control" id="goodsDesc" name="goodsDesc" rows="20" cols="60"></textarea>
                </div>
                <button type="submit" class="btn btn-success">提交</button>
                <a href="javascript:history.go(-1)" class="btn btn-default">返回</a>
            </form>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->

<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog"
     tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="avatar-form" action="{{U('backyard/Image/uploadHeaderImg')}}" enctype="multipart/form-data"
                  method="post">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                    <h4 class="modal-title" id="avatar-modal-label">上传商品图片</h4>
                </div>
                <div class="modal-body">
                    <div class="avatar-body">
                        <div class="avatar-upload">
                            <input class="avatar-src" name="avatar_src" type="hidden">
                            <input class="avatar-data" name="avatar_data" type="hidden">
                            <label for="avatarInput">图片上传</label>
                            <input class="avatar-input" id="avatarInput" name="avatar_file" type="file"></div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar-preview preview-lg"></div>
                                <div class="avatar-preview preview-md"></div>
                                <div class="avatar-preview preview-sm"></div>
                            </div>
                        </div>
                        <div class="row avatar-btns">
                            <div class="col-md-3">
                                <button class="btn btn-success btn-block avatar-save" type="submit"><i
                                            class="fa fa-save"></i> 保存修改
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>

</body>
<!-- jQuery -->
<script src="__PUBLIC__/js/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="__PUBLIC__/js/bootstrap.min.js"></script>

<script src="__PUBLIC__/js/wangEditor.min.js"></script>
<script src="__PUBLIC__/js/cropper.min.js"></script>
<script src="__PUBLIC__/js/sitelogo.js"></script>
<script language="JavaScript">
    $(function () {
        var editor = new wangEditor('goodsDesc');
        editor.config.uploadImgUrl = '{{U('backyard/Image/uploadImg')}}';
        editor.config.hideLinkImg = true;
        editor.create();

        $.getJSON("{{U('backyard/Goods/getTypeList')}}", function (data) {
            $.each(data, function (i, item) {
                $("#goodsType").append("<option value='" + item.tid + "'>" + item.tname + "</option>");
            });
        });
    })
</script>
</html>
