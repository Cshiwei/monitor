<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>影响</title>
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
                <div class="col-xs-1">
                    <p><a type="button" class="btn btn-primary" href="/effect/add">添加</a></p>
                </div>
                <div  class="col-xs-9">
                    <form class="form-inline" method="get" action="/effect">
                        <div class="form-group">
                            <label class="sr-only" for="name">like:name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="name" value="<{$name}>">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="norm">=:norm</label>
                            <input type="text" class="form-control" id="norm" name="norm" placeholder="norm" value="<{$norm}>">
                        </div>
                        <div class="form-group hidden">
                            <input type="submit" class="form-control" id="exampleInputPassword3" >
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" >
                    <table class="table table-condensed">
                        <th>
                        <td>ID</td>
                        <td>名称</td>
                        <td>分组</td>
                        <td>描述</td>
                        <td>操作</td>
                        </th>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr>
                                <td></td>
                                <td><{$val.id}></td>
                                <td><{$val.name}></td>
                                <td><{$val.groupShow}></td>
                                <td><{$val.desc}></td>
                                <td>
                                    <a class="btn btn-default btn-xs effect-norm" data-id="<{$val.id}>" role="button" href="/effect/norm?effectId=<{$val.id}>">指标</a>
                                    <a class="btn btn-default btn-xs edit-effect" data-id="<{$val.id}>" href="/effect/edit?effectId=<{$val.id}>" role="button">编辑</a>
                                    <button class="btn btn-default btn-xs del-effect" data-id="<{$val.id}>" data-name="<{$val.name}>" role="button" data-toggle="modal" data-target="#delEffectModel">删除</button>
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
    </div>
</div>

<!--模态框-->

<!--删除指标确认框-->
<div class="modal fade" tabindex="-1" role="dialog" id="delEffectModel">
    <form method="post" name="delEffectFm" action="/effect/del">
        <input type="hidden" id="delEffectId" name="effectId" value="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">确认</h4>
                </div>
                <div class="modal-body">
                    <p>删除影响【<span id="showEffect"></span>】之后数据将无法恢复</p>
                    <p>并且该影响与指标的对应关系也将删除，请确认操作&hellip;</p>
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
    $('#delEffectModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var name = button.data('name');
        $("#showEffect").text(name);
        $("#delEffectId").val(id);
    })
</script>
</html>