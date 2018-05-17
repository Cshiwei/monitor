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
                                <li><a data-name="<{$info.name}>" data-id="<{$info.id}>" id="delBehavior" data-toggle="modal" data-target="#delBehaviorModal">删除</a></li>
                            </ul>
                        </div>
                        <h4><{$info.name}><small> <{$info.jobNameShow}></small></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <p>描述：<{$info.desc}></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <hr/>
                </div>
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
</script>
</html>