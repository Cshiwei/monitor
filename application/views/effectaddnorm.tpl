<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>影响-添加指标</title>

    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/common.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <!--banner -->
    <{include file="common/banner.tpl" }>
    <!--/banner-->
    <div class="row">
        <!--slidebar-->
        <{include file="common/slidebar.tpl"}>
        <!--/slidebar-->
        <div class="col-xs-9">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-header">
                        <h4><{$info.name}><small> 添加指标</small></h4>
                    </div>
                </div>
            </div>
            <form class="form-horizontal" id="addNormFm" name="addNormFm" method="post" action="/effect/addNorm">
                <input type="hidden" name="action" value="doAdd"/>
                <input type="hidden" name="effectId" value="<{$info.id}>"/>
                <div class="form-group">
                    <div class="col-xs-12">
                        <{foreach $list as $val}>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="normCheck" name="normCheck[]" value="<{$val.id}>"> <{$val.name}>
                            </label>
                        <{/foreach}>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-xs-12">
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-10">
                    <button type="button" id="doAddNorm" disabled="disabled" class="btn btn-primary">添加</button>
                    <a class="btn btn-primary btn-sm" href="/effect/norm?effectId=<{$info.id}>">返回</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/js/common.js"></script>
<script>
    //判断添加按钮是否可点击
    $(function(){
        var checkboxes = $(".normCheck"),
            submitButt = $("#doAddNorm");

            checkboxes.click(function() {
            submitButt.attr("disabled", !checkboxes.is(":checked"));
        });
    })
    //点击添加
    $(function(){
        $("#doAddNorm").click(function(){
            $('#addNormFm').submit();
        })
    })
</script>
</html>