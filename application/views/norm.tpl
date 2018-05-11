<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>指标</title>

    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/common.css">
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
        <p>
            <a type="button" class="btn btn-primary" href="/norm/addnorm">添加</a>
        </p>
        <table class="table table-condensed">
            <th>
            <td>ID</td>
            <td>名称</td>
            <td>阈值</td>
            <td>描述</td>
            <td>操作</td>
            </th>
            <tbody>
            <{foreach $list as $val}>
                <tr class="<{$val.scene}>">
                    <td></td>
                    <td><{$val.id}></td>
                    <td><{$val.name}></td>
                    <td><{$val.thresholdShow}></td>
                    <td class="td-hidden"><{$val.desc}></td>
                    <td>
                    <!--
                    <a class="btn btn-default btn-xs effect-norm" href="/effect?norm=<{$val.name}>" data-id="<{$val.id}>" role="button">影响</a>
                    -->
                    <a class="btn btn-default btn-xs" href="/norm/normDetail?normId=<{$val.id}>" role="button">详情</a>
                    <a class="btn btn-default btn-xs edit-norm" data-id="<{$val.id}>" href="/norm/editNorm?normId=<{$val.id}>" role="button">编辑</a>
                    <button class="btn btn-default btn-xs del-norm" data-id="<{$val.id}>" data-name="<{$val.name}>" role="button" data-toggle="modal" data-target="#delNormModel">删除</button>
                    </td>
                </tr>
            <{/foreach}>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <{$pageShow}>
         </nav>
    </div>
</div>
</div>

<!--模态框-->

<!--删除指标确认框-->
<div class="modal fade" tabindex="-1" role="dialog" id="delNormModel">
    <form method="post" name="delNormFm" action="/norm/delNorm">
        <input type="hidden" id="delNormId" name="normId" value="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">确认</h4>
                </div>
                <div class="modal-body">
                    <p>删除指标【<span id="showNorm"></span>】之后数据将无法恢复</p>
                    <p>并且影响与该指标的对应关系也将删除，请确认操作&hellip;</p>
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
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script>
    //模态框展示之后操作 将操作参数赋值到模态框
    $('#delNormModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var name = button.data('name');
        $("#delNormId").val(id);
        $("#showNorm").text(name);
    })
</script>
</body>
</html>