<!--Created by MasterHo on 2016.12.06 via IntelliJ IDEA.-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form action="{{U('Admin/Goods/uploadImg')}}" enctype="multipart/form-data" method="post">
    upload:<input type="file" name="photo">
    <button type="submit">submit</button>
</form>
</body>
</html>