<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>指标详情</title>

    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/common.css" rel="stylesheet">
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
                                <li><a href="/norm/lineChart?normId=<{$info.id}>">图表</a></li>
                                <!--
                                <li><a href="/norm/joinBehavior?normId=<{$info.id}>">关联行为</a></li>
                                -->
                            </ul>
                        </div>
                        <h4><{$info.name}><small> 详情</small></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-9">
                    <form class="form-inline "  method="get" action="/norm/normDetail">
                    <input type="hidden" name="normId" value="<{$info.id}>"/>
                        <div class="form-group">
                            <label class="sr-only" for="name">time</label>
                            <input type="text" class="form-control" id="day" name="day" placeholder="day:20180510" value="">
                        </div>
                        <div class="form-group hidden">
                            <input type="submit" class="form-control" id="exampleInputPassword3" >
                        </div>
                    </form>
                    <br/>
                    <div class="pre-scrollable">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th></th>
                                <th>序号</th>
                                <th>值</th>
                                <th>时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            <{foreach $list as $key=>$val}>
                                <tr class="<{$val.scene}>">
                                    <td></td>
                                    <td><{$val@iteration}></td>
                                    <td><{$val.valueShow}></td>
                                    <td><{$val.normTimeShow}></td>
                                </tr>
                            <{/foreach}>
                            </tbody>
                        </table>
                    </div>
                    <{$pageShow}>
                </div>
                <div class="col-xs-7" >
                    <div id="main" style="height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/js/echarts.min.js"></script>
</html>