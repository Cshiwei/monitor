<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加行为</title>
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
                    <label for="desc" class="col-xs-2 control-label">描述</label>
                    <div class="col-xs-10">
                        <textarea name="desc" class="form-control" id="desc" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group" id="itemGroup">
                    <label for="normId" class="col-xs-2 control-label">触发条件</label>
                    <div class="col-xs-5">
                        <select class="form-control" id="normId" name="normId" title="指标ID">
                            <{foreach $allNorm as $key=>$val}>
                                <option  value="<{$val.id}>"><{$val.name}>&nbsp;&nbsp;&nbsp;&nbsp;<{$val.thresholdShow}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="taskType" class="col-xs-2 control-label">任务类型</label>
                    <div class="col-xs-2">
                        <select id="taskType" name="taskType" class="form-control">
                            <{foreach $taskType as $key=>$val}>
                                <option class="form-control" value="<{$val.val}>" data-param="<{$val.paramFm}>"><{$val.name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <hr/>
                    </div>
                </div>
                <div id="paramFm">

                </div>
                <div class="param hidden">
                    <div id="emailFm">
                        <!-- 邮件参数-->
                        <div class="form-group emailFm">
                            <label for="emailTitle" class="col-xs-2 control-label">邮件标题</label>
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <div class="input-group-addon">【Monitor】</div>
                                    <input id="emailTitle" class="form-control" type="text" name="emailTitle"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group emailFm">
                            <label for="emailTo" class="col-xs-2 control-label">收件人</label>
                            <div class="col-xs-6">
                                <textarea name="emailTo" class="form-control" id="emailTo" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group emailFm">
                            <label for="emailContent" class="col-xs-2 control-label">邮件内容</label>
                            <div class="col-xs-7">
                                <textarea name="emailContent" class="form-control" id="emailContent" rows="3"></textarea>
                            </div>
                        </div>
                        <!-- 邮件参数 -->
                    </div>
                </div>

                <!--
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
                -->
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
            var desc = $("#desc").val();
            var normId = $("#normId").val();
            var taskType = $("#taskType").val();
            var emailTitle = $("#emailTitle").val();
            var emailTo = $("#emailTo").val();
            var emailContent = $("#emailContent").val();

           if(name===''){
                addAlert(alertObj,'名称不可以为空');
                $("#name").focus();
                return false;
            }

            if(desc===''){
                addAlert(alertObj,'描述不可以为空');
                $("#desc").focus();
                return false;
            }

            if(taskType==1){
                if(emailTitle===''){
                    addAlert(alertObj,'邮件标题不可以为空');
                    $("#emailTitle").focus();
                    return false;
                }

                if(emailTo===''){
                    addAlert(alertObj,'收件人不可以为空');
                    $("#emailTo").focus();
                    return false;
                }

                if(emailContent ===''){
                    addAlert(alertObj,'邮件内容不可以为空');
                    $("#emailContent").focus();
                    return false;
                }

                taskParam={
                    emailTitle:emailTitle,
                    emailTo:emailTo,
                    emailContent:emailContent,
                };
            }

            var url ="/behavior/add"
            $.post(url,{
                name:name,
                desc:desc,
                normId:normId,
                taskType:taskType,
                taskParam:taskParam,
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
       $("#taskType").change(function(){
           var param = $("#taskType option:selected").data('param');
           var html = $("#"+param).html();
           $("#paramFm").html(html);
       })

        $("#taskType").change();
    })


</script>
</html>