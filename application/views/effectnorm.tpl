<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>影响-指标</title>

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
                        <h4><{$info.name}><small> 指标</small></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <{if $list}>
                    <{foreach $list as $val}>
                        <div class="col-xs-3 norm-panel">
                            <div class="panel panel-<{$val.panelType}>">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><{$val.name}>
                                        <button type="button" data-effectId="<{$info.id}>" data-normId="<{$val.id}>" class="close del-norm" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </h3>
                                </div>
                                <div class="panel-body normDetail" style="cursor:pointer" data-normId="<{$val.id}>">
                                    <{$val.recentValShow}>
                                    <span class="glyphicon glyphicon-option-horizontal pull-right" aria-hidden="true" ></span>
                                </div>
                            </div>
                        </div>
                    <{/foreach}>
                <{/if}>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-10">
                    <a type="button" href="/effect/addNorm?effectId=<{$info.id}>" class="btn btn-primary">添加</a>
                    <a type="button" href="/effect" class="btn btn-primary">返回</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--模态框-->
<!-- Modal -->
<div class="modal fade" id="normMoreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<!--/模态框-->
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/js/common.js"></script>
<script>
   $(function(){
       //点击删除指标
        $(".del-norm").click(function(){
            var parentPanel = $(this).parents(".norm-panel");
            var normId = $(this).attr('data-normId');
            var effectId = $(this).attr('data-effectId');
            var url = '/effect/delNorm';
            $.post(url,{effectId:effectId,normId:normId},function(res){
                if(res.errNo===0){
                    parentPanel.remove();
                }else{
                    myAlert('删除失败！');
                }
            })
        })
   })

    $(function(){
        $(".normDetail").click(function(){
            var url = '/effect/normRecent';
            var normId = $(this).attr('data-normId');
            $.post(url,{normId:normId},function(res){
                if(res.errNo===0){
                    $('#normMoreModal .modal-content').html(res.result.html);
                    $('#normMoreModal').modal('show');
                }else{
                    myAlert(res.errMsg);
                }
            })
        })
    })
</script>
</html>