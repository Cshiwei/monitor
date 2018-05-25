<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加指标</title>

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
                        <div class="dropdown pull-right">
                        </div>
                        <h4>添加指标<small> </small></h4>
                    </div>
                </div>
            </div>
            <!--提示信息-->
            <div class="row">
                <div class="col-xs-12" id="alertDom">
                </div>
            </div>
            <!--/提示信息-->
            <form class="form-horizontal" name="addNorm" method="post">
                <div class="form-group">
                    <label for="normName" class="col-sm-2 control-label">指标名称</label>
                    <div class="col-xs-5">
                        <input type="text" id="normName" name="normName" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="normDesc" class="col-sm-2 control-label">描述</label>
                    <div class="col-xs-10">
                        <textarea name="normDesc" class="form-control" id="normDesc" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="normRelation" class="col-sm-2 control-label">阈值</label>
                    <div class="col-xs-2">
                        <select id="normRelation" name="normRelation" class="form-control">
                            <{foreach $relationArr as $val}>
                            <option value="<{$val.val}>"><{$val.name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <input type="text" id="normThreshold" name="normName" class="form-control" placeholder="1000">
                    </div>
                    <div class="col-xs-2">
                        <select id="normUnit" name="normUnit" class="form-control">
                            <{foreach $unitArr as $val}>
                                <option value="<{$val.val}>"><{$val.name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" id="addNorm" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/js/common.js"></script>
<script>
    //点击提交按钮检测表单数据是否合法
        $('#addNorm').click(function(){
            var normName = $('#normName').val();
            var normDesc = $('#normDesc').val();
            var normRelation = $('#normRelation').val();
            var normThreshold = $('#normThreshold').val();
            var normUnit = $('#normUnit').val();
            var alertObj = $('#alertDom');

            if(normName === '')
            {
                $('#normName').focus();
                addAlert(alertObj,'请输入指标名称','danger');
                return false;
            }

            if(normDesc === '')
            {
                $('#normDesc').focus();
                addAlert(alertObj,'请输入描述');
                return false;
            }

            if(normThreshold === '')
            {
                $('#normThreshold').focus();
                addAlert(alertObj,'请输入阈值');
                return false;
            }

            if(normUnit === '')
            {
                $('#normUnit').focus();
                addAlert(alertObj,'请输入阈值单位');
                return false;
            }
            $("#addNorm").attr('disabled','disabled');
            var url = "/norm/addNorm"
            $.post(url,
                {
                    normName:normName,
                    normDesc:normDesc,
                    normRelation:normRelation,
                    normThreshold:normThreshold,
                    normUnit:normUnit
                },
                function (res) {
                    var errNo = res.errNo;
                    if(errNo===0)
                    {
                        addAlert(alertObj,'添加成功,2秒后刷新页面','success');
                        setTimeout("location.href='/norm'",2000);
                    }
                    else
                    {
                        $("#addNorm").removeAttr('disabled');
                        addAlert(alertObj,res.errMsg);
                    }
                }
            )
        })
</script>
</body>
</html>