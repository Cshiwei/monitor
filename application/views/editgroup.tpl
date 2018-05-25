<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>编辑分组</title>

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
                        <h4>编辑分组<small> </small></h4>
                    </div>
                </div>
            </div>
            <!--提示信息-->
            <div class="row">
                <div class="col-xs-12" id="alertDom">
                </div>
            </div>
            <!--/提示信息-->
            <form class="form-horizontal" name="addGroup" method="post">
                <input id="groupId" name="id" type="hidden" value="<{$info.id}>">
                <div class="form-group">
                    <label for="groupName" class="col-xs-2 control-label">分组名称</label>
                    <div class="col-xs-5">
                        <input type="text" id="groupName" name="groupName" class="form-control" value="<{$info.name}>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="groupDesc" class="col-xs-2 control-label">描述</label>
                    <div class="col-xs-10">
                        <textarea name="groupDesc" class="form-control" id="groupDesc" rows="3"><{$info.desc}></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" id="editGroup" class="btn btn-primary">提交</button>
                        <button type="reset" class="btn btn-primary">重置</button>
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
        $("#editGroup").click(function () {
            var groupId = $("#groupId").val();
            var groupName = $("#groupName").val();
            var groupDesc = $("#groupDesc").val();
            var alertDom = $("#alertDom");

           if(groupName === '')
                addAlert(alertDom,'无效的分组名称');

            if(groupDesc === '')
                addAlert(alertDom,'无效的描述');

            var url = '/group/edit';
            $('#editGroup').attr('disabled','disabled');
            $.post(url,
                {
                    id:groupId,
                    name:groupName,
                    desc:groupDesc
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
                        $('#editGroup').removeAttr('disabled');
                        addAlert(alertDom,res.errMsg);
                    }
                });
        })
    })
</script>
</html>