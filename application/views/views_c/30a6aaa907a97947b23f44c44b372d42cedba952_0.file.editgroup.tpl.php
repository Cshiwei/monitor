<?php
/* Smarty version 3.1.32, created on 2018-05-11 10:09:10
  from 'G:\www\monitor\application\views\editgroup.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af4fb468cf7a8_08451273',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '30a6aaa907a97947b23f44c44b372d42cedba952' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\editgroup.tpl',
      1 => 1525858269,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/banner.tpl' => 1,
    'file:common/slidebar.tpl' => 1,
  ),
),false)) {
function content_5af4fb468cf7a8_08451273 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>编辑分组</title>

    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <!--banner -->
    <?php $_smarty_tpl->_subTemplateRender("file:common/banner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <!--/banner-->
    <div class="row">
        <!--slidebar-->
        <?php $_smarty_tpl->_subTemplateRender("file:common/slidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <!--/slidebar-->
        <div class="col-xs-9">
            <!--提示信息-->
            <div class="row">
                <div class="col-xs-12" id="alertDom">
                </div>
            </div>
            <!--/提示信息-->
            <form class="form-horizontal" name="addGroup" method="post">
                <input id="groupId" name="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
">
                <div class="form-group">
                    <label for="groupName" class="col-xs-2 control-label">分组名称</label>
                    <div class="col-xs-5">
                        <input type="text" id="groupName" name="groupName" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
">
                    </div>
                </div>
                <div class="form-group">
                    <label for="groupDesc" class="col-xs-2 control-label">描述</label>
                    <div class="col-xs-10">
                        <textarea name="groupDesc" class="form-control" id="groupDesc" rows="3"><?php echo $_smarty_tpl->tpl_vars['info']->value['desc'];?>
</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" id="editGroup" class="btn btn-primary">提交</button>
                        <button type="reset" class="btn btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<?php echo '<script'; ?>
 src="/static/js/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/static/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/static/js/common.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    $(function(){
        $("#editGroup").click(function () {
            var groupId = $("#groupId").val();
            var groupName = $("#groupName").val();
            var groupDesc = $("#groupDesc").val();
            var alertDom = $("#alertDom");

           if(groupName === '')
                addAlert(alertDom,'无效的分组名称');

            if(groupDesc === '')
                addAlert(alertDom,'无效的描述');

            var url = '/group/edit';
            $('#editGroup').attr('disabled','disabled');
            $.post(url,
                {
                    id:groupId,
                    name:groupName,
                    desc:groupDesc
                },
                function(res){
                    var errNo = res.errNo;
                    if(errNo===0)
                    {
                        addAlert(alertDom,'更新成功,3秒后刷新页面','success');
                        setTimeout("location.reload()",3000);
                    }
                    else
                    {
                        $('#editGroup').removeAttr('disabled');
                        addAlert(alertDom,res.errMsg);
                    }
                });
        })
    })
<?php echo '</script'; ?>
>
</html><?php }
}
