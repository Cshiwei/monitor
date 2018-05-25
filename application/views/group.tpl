<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>影响分组</title>

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
            <p>
                <a type="button" class="btn btn-primary" href="/group/add">添加</a>
            </p>
            <table class="table table-condensed">
                <th>
                <td>ID</td>
                <td>名称</td>
                <td>描述</td>
                <td>操作</td>
                </th>
                <tbody>
                <{foreach $list as $val}>
                    <tr>
                        <td></td>
                        <td><{$val.id}></td>
                        <td><{$val.name}></td>
                        <td><{$val.desc}></td>
                        <td>
                            <!--
                            <button class="btn btn-default btn-xs group-effect" data-id="<{$val.id}>" role="button">影响</button>
                            -->
                            <a class="btn btn-default btn-xs edit-group" data-id="<{$val.id}>" href="/group/edit?groupId=<{$val.id}>" role="button">编辑</a>
                            <button class="btn btn-default btn-xs del-group" data-id="<{$val.id}>" data-name="<{$val.name}>" role="button" data-toggle="modal" data-target="#delGroupModel">删除</button>
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
<div class="modal fade" tabindex="-1" role="dialog" id="delGroupModel">
    <form method="post" name="delGroupFm" action="/group/del">
        <input type="hidden" id="delGroupId" name="groupId" value="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">确认</h4>
                </div>
                <div class="modal-body">
                    <p>删除分组【<span id="showGroup"></span>】之后数据将无法恢复</p>
                    <p>请确保已经没有【影响】属于该分组，否则将无法删除，请确认操作&hellip;</p>
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
    //模态框展示之后操作 将操作参数赋值到模态框
    $('#delGroupModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var name = button.data('name');
        $("#delGroupId").val(id);
        $("#showGroup").text(name);
    })
</script>
</html>