<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Behavior</title>

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
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <li>
                                    <{if $info.status eq 0}>
                                        <a data-id="<{$info.id}>" id="enableBehavior">启用</a>
                                    <{else}>
                                        <a data-id="<{$info.id}>" id="disabledBehavior">禁用</a>
                                    <{/if}>
                                </li>
                                <li><a href="/behavior/edit?id=<{$info.id}>">编辑</a></li>
                                <li><a data-name="<{$info.name}>" data-id="<{$info.id}>" id="delBehavior" data-toggle="modal" data-target="#delBehaviorModal">删除</a></li>
                            </ul>
                        </div>
                        <h4><{$info.name}><small></small></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <p>状态：<{$info.statusShow}></p>
                    <p>触发指标:<{$info.thresholdShow}></p>
                    <p>描述：<{$info.desc}></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <hr/>
                </div>
            </div>
            <div class="row">
                <{if $info.taskType eq 1}>
                    <div class="col-xs-12">
                        <p>任务类型: 邮件</p>
                        <p>邮件标题：<{$info.taskInfo.title}></p>
                        <p>收件人：<{$info.taskInfo.emailTo}></p>
                        <p>邮件内容:<{$info.taskInfo.content}></p>
                    </div>
                <{/if}>
            </div>
        </div>
    </div>
</div>

<!--模态框-->

<!--删除指标确认框-->
<div class="modal fade" tabindex="-1" role="dialog" id="delBehaviorModal">
    <form method="post" name="delBehavior" action="/behavior/del">
        <input type="hidden" id="behaviorId" name="id" value="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">确认</h4>
                </div>
                <div class="modal-body">
                    <p>删除行为【<span id="showBehavior"></span>】之后数据将无法恢复</p>
                    <p>请确认操作&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary" >删除</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->
<!--/删除指标确认框-->

<!--/模态框-->
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/js/common.js"></script>
<script>
    $(function(){
        //模态框展示之后操作 将操作参数赋值到模态框
        $('#delBehaviorModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes
            var name = button.data('name');
            $("#showBehavior").text(name);
            $("#behaviorId").val(id);
        })
    })

    $(function(){
        $("#enableBehavior").click(function(){
            var id = $(this).data("id");
            var url = "/behavior/enableBehavior";
            $.post(url,{id:id},function(res){
                if(res.errNo===0){
                    myAlert("启用成功,即将刷新页面");
                    setTimeout("window.location.reload()",2000);
                }else{
                    myAlert(res.errMsg);
                }
            })
        })

        $("#disabledBehavior").click(function(){
            var id = $(this).data("id");
            var url = '/behavior/disabledBehavior';
            $.post(url,{id:id},function(res){
                if(res.errNo===0){
                    myAlert("禁用成功，即将刷新页面");
                    setTimeout("window.location.reload()",2000);
                }else{
                    myAlert(res.errMsg);
                }
            })
        })

    })
</script>
</html>