<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>编辑指标</title>

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
                        <h4>添加触发器<small> </small></h4>
                    </div>
                </div>
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
            <label for="type" class="col-xs-2 control-label">触发器类型</label>
            <div class="col-xs-3">
                <select id="type" name="type" class="form-control">
                    <{foreach $typeArr as $key=>$val}>
                        <option value="<{$val.val}>"><{$val.name}></option>
                    <{/foreach}>
                </select>
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
                <button type="button" id="addTrigger" class="btn btn-primary">提交</button>
            </div>
        </div>
    </form>
</div>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/js/common.js"></script>
<script>
    $(function(){
        $("addTrigger").click(function(){
            var alertObj = $("#alertDom");
            var name = $("#name").val();
            var type = $("#type").val();
            var desc = $("#desc").val();

            if(name ==='') {
                addAlert(alertObj,'触发器名称不能为空');
                return false;
            }

            if(desc === '') {
                addAlert(alertObj,"描述不可以为空");
                return false;
            }
            var url ="/behavior/addTrigger";
            $.post(url,{
                name : name,
                type : type,
                desc : desc,
            },function(res){
                if(res.errNo!==0){
                    addAlert(alertObj,res.errMsg);
                }else{
                    addAlert(alertObj,"添加成功,即将跳转");
                    setTimeout("location.href='/behavior'",1000)
                }
            })

        })
    })
</script>
</html>