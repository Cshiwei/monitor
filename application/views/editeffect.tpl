<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>编辑指标</title>

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
                        <h4>编辑影响<small> </small></h4>
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
                <input type="hidden" name="effectId" value="<{$info.id}>" id="effectId"/>
                <div class="form-group">
                    <label for="effectName" class="col-xs-2 control-label">影响名称</label>
                    <div class="col-xs-5">
                        <input type="text" id="effectName" name="effectName" class="form-control" value="<{$info.name}>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="effectName" class="col-xs-2 control-label">分组</label>
                    <div class="col-xs-5">
                        <select class="form-control" name="group" id="effectGroup">
                            <{foreach $groupList as $val}>
                                <option <{if $info.groupId eq $val.id}>selected<{/if}> value="<{$val.id}>"><{$val.name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="effectDesc" class="col-xs-2 control-label">描述</label>
                    <div class="col-xs-10">
                        <textarea name="effectDesc" class="form-control" id="effectDesc" rows="3"><{$info.desc}></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" id="editEffect" class="btn btn-primary">提交</button>
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
        $("#editEffect").click(function () {
            var effectId = $("#effectId").val();
            var effectName = $("#effectName").val();
            var effectGroup = $("#effectGroup").val();
            var effectDesc = $("#effectDesc").val();
            var alertDom = $("#alertDom");

            if(effectName === '')
                addAlert(alertDom,'无效的影响名称');

            if(effectDesc === '')
                addAlert(alertDom,'无效的描述');

            $("#editEffect").attr('disabled','disabled');
            var url = '/effect/edit';
            $.post(url,
                {
                    id:effectId,
                    name:effectName,
                    group:effectGroup,
                    desc:effectDesc
                },
                function(res){
                    var errNo = res.errNo;
                    if(errNo===0)
                    {
                        addAlert(alertDom,'更新成功,3秒后刷新页面','success');
                        setTimeout("location.reload()",3000);
                    }
                    else
                    {
                        $("#editEffect").removeAttr('disabled');
                        addAlert(alertDom,res.errMsg);
                    }
                });
        })
    })
</script>
</html>