<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>行为</title>

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
            <p>
                <a type="button" class="btn btn-primary" href="/behavior/add">添加</a>
            </p>
            <table class="table table-condensed">
                <th>
                <td>ID</td>
                <td>名称</td>
                <td>描述</td>
                <td>状态</td>
                <td>操作</td>
                </th>
                <tbody>
                <{foreach $list as $val}>
                    <tr class="">
                        <td></td>
                        <td><{$val.id}></td>
                        <td><{$val.name}></td>
                        <td class="td-hidden"><{$val.desc}></td>
                        <td><{$val.statusShow}></td>
                        <td>
                            <!--
                    <a class="btn btn-default btn-xs effect-norm" href="/effect?norm=<{$val.name}>" data-id="<{$val.id}>" role="button">影响</a>
                    -->
                            <!--
                            <{if $val.status eq 0}>
                                <a class="btn btn-default btn-xs" id="enableBehavior" data-id="<{$val.id}> ">启用</a>
                            <{else}>
                                <a class="btn btn-default btn-xs" id="disabledBehavior" data-id="<{$val.id}> ">禁用</a>
                            <{/if}>
                            -->
                            <a class="btn btn-default btn-xs" href="/behavior/detail?id=<{$val.id}>" role="button">详情</a>
                            <a class="btn btn-default btn-xs edit-norm" data-id="<{$val.id}>" href="/behavior/edit?id=<{$val.id}>" role="button">编辑</a>
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
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/js/common.js"></script>
<script>
</script>
</html>