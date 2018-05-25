<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加影响</title>
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
                        <h4>添加影响<small> </small></h4>
                    </div>
                </div>
            </div>
            <!--提示信息-->
            <div class="row">
                <div class="col-xs-12" id="alertDom">
                </div>
            </div>
            <!--/提示信息-->
            <form class="form-horizontal" name="addEffect" method="post">
                <div class="form-group">
                    <label for="effectName" class="col-xs-2 control-label">影响名称</label>
                    <div class="col-xs-5">
                        <input type="text" id="effectName" name="effectName" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="effectName" class="col-xs-2 control-label">分组</label>
                    <div class="col-xs-5">
                        <select class="form-control" name="group" id="effectGroup">
                            <{foreach $groupList as $val}>
                                <option value="<{$val.id}>"><{$val.name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <a href="/group/add">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="effectDesc" class="col-xs-2 control-label">描述</label>
                    <div class="col-xs-10">
                        <textarea name="effectDesc" class="form-control" id="effectDesc" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" id="addEffect" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/js/common.js"></script>
<script>
    $(function(){
        $("#addEffect").click(function () {
            var effectName = $("#effectName").val();
            var effectGroup = $("#effectGroup").val();
            var effectDesc = $("#effectDesc").val();
            var alertDom = $("#alertDom");

           if(effectName === '')
                addAlert(alertDom,'无效的影响名称');

            if(effectDesc === '')
                addAlert(alertDom,'无效的描述');

            $("#addEffect").attr('disabled','disabled');
            var url = '/effect/add';
            $.post(url,
                {
                    name:effectName,
                    group:effectGroup,
                    desc:effectDesc
                },
                function(res){
                var errNo = res.errNo;
                if(errNo===0)
                {
                    addAlert(alertDom,'添加成功,3秒后刷新页面','success');
                    setTimeout("location.href='/effect'",3000);
                }
                else
                {
                    $("#addEffect").removeAttr('disabled');
                    addAlert(alertDom,res.errMsg);
                }
            });
        })
    })
</script>
</html>