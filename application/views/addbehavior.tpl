<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加行为</title>

    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
                            <!--
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <li><a href="/behavior/runBehavior?id=">运行</a></li>
                                <li><a href="/behavior">列表</a></li>
                            </ul>
                            -->
                        </div>
                        <h4>添加行为<small> </small></h4>
                    </div>
                </div>
            </div>
            <!--提示信息-->
            <div class="row">
                <div class="col-xs-12" id="alertDom">
                </div>
            </div>
            <!--/提示信息-->
            <form class="form-horizontal" name="addBehavior" method="post">
                <div class="form-group">
                    <label for="name" class="col-xs-2 control-label">名称</label>
                    <div class="col-xs-5">
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-xs-2 control-label">行为类型</label>
                    <div class="col-xs-5">
                    <{foreach $behaviorType as $key=>$val}>
                        <label class="radio-inline">
                            <input <{if $val.default}>checked<{/if}> type="radio" name="behaviorType" value="<{$val.val}>"> <{$val.name}>
                        </label>
                    <{/foreach}>
                    </div>
                </div>
                <div class="form-group" >
                    <label for="trigger" class="col-xs-2 control-label">触发条件</label>
                    <div class="col-xs-5">
                        <select id="trigger" name="trigger" id="" class="form-control">
                            <{foreach $trigger as $key=>$val}>
                                <option value="<{$val.val}>" title="<{$val.desc}>" ><{$val.name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="itemGroup">
                    <label for="normId" class="col-xs-2 control-label">触发项目</label>
                    <div class="col-xs-5">
                        <select class="form-control" id="normId" name="normId" title="指标ID">
                            <{foreach $allNorm as $key=>$val}>
                                <option  value="<{$val.id}>"><{$val.name}>&nbsp;&nbsp;&nbsp;&nbsp;<{$val.thresholdShow}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="jobType" class="col-xs-2 control-label">任务</label>
                    <div class="col-xs-2">
                        <select id="jobType" name="jobType" class="form-control">
                            <{foreach $jobType as $key=>$val}>
                                <option class="form-control" value="<{$val.val}>"><{$val.name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <input class="form-control" type="text" id="jobName" name="jobName" placeholder="sendEmail"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc" class="col-xs-2 control-label">描述</label>
                    <div class="col-xs-10">
                        <textarea name="desc" class="form-control" id="desc" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" id="addBehavior" class="btn btn-primary">提交</button>
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
        //ajax提交添加表单
        $("#addBehavior").click(function(){
            var alertObj = $("#alertDom");

            var name = $("#name").val();
            var behaviorType = $("input[name='behaviorType']:checked").val();
            var trigger = $("#trigger").val();
            var normId = $("#normId").val();
            var jobType = $("#jobType").val();
            var jobName = $("#jobName").val();
            var desc = $("#desc").val();

            if(name===''){
                addAlert(alertObj,'名称不可以为空');
                $("#name").focus();
                return false;
            }

            if(jobName===''){
                addAlert(alertObj,'任务不可以为空');
                $("#jobName").focus();
                return false;
            }

            if(desc===''){
                addAlert(alertObj,'描述不可以为空');
                $("#desc").focus();
                return false;
            }

            var url ="/behavior/add"
            $.post(url,{
                name:name,
                behaviorType:behaviorType,
                trigger:trigger,
                normId:normId,
                jobType:jobType,
                jobName:jobName,
                desc:desc,
            },function(res){
                if(res.errNo===0){
                    addAlert(alertObj,'添加成功，即将跳转','success');
                    setTimeout("location.href='/behavior'",1000);
                }else{
                    addAlert(alertObj,res.errMsg);
                }
            });
        })
    })

    //变更行为类型，更改表单
    $(function(){
       $("input[name='behaviorType']").change(function(){
            $("#itemGroup").fadeToggle("normal");
       });
    })

</script>
</html>