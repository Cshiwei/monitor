<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>success</title>

    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <!--banner -->
    <{include file="common/banner.tpl" }>
    <!--/banner-->
    <div class="row">
        <div class="col-xs-offset-1 col-xs-8">
            <div class="jumbotron">
                <h2>success!</h2>
                <p>操作成功：<{$msg}></p>
                <p><span id="stay"></span>秒后跳转</p>
                <p><a class="btn btn-primary btn-lg" href="<{$url}>" role="button">返回</a></p>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script>
    $(function() {
        function showTime(count) {
            document.getElementById('stay').innerHTML = count;
            if (count == 0) {
                location.href = '<{$url}>';
            } else {
                count -= 1;
                setTimeout(function () {
                    showTime(count);
                }, 1000);
            }
        }
        showTime(<{$stay}>);
    })
</script>
</html>