<?php
/* Smarty version 3.1.32, created on 2018-05-11 10:03:31
  from 'G:\www\monitor\application\views\addeffect.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af4f9f3897441_72664767',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2d351a200dd374c8536db40e27a4dc5385c574aa' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\addeffect.tpl',
      1 => 1525858350,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/banner.tpl' => 1,
    'file:common/slidebar.tpl' => 1,
  ),
),false)) {
function content_5af4f9f3897441_72664767 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加影响</title>
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
            <form class="form-horizontal" name="addEffect" method="post">
                <div class="form-group">
                    <label for="effectName" class="col-xs-2 control-label">影响名称</label>
                    <div class="col-xs-5">
                        <input type="text" id="effectName" name="effectName" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="effectName" class="col-xs-2 control-label">分组</label>
                    <div class="col-xs-5">
                        <select class="form-control" name="group" id="effectGroup">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['groupList']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <a href="/group/add">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="effectDesc" class="col-xs-2 control-label">描述</label>
                    <div class="col-xs-10">
                        <textarea name="effectDesc" class="form-control" id="effectDesc" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" id="addEffect" class="btn btn-primary">提交</button>
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
        $("#addEffect").click(function () {
            var effectName = $("#effectName").val();
            var effectGroup = $("#effectGroup").val();
            var effectDesc = $("#effectDesc").val();
            var alertDom = $("#alertDom");

           if(effectName === '')
                addAlert(alertDom,'无效的影响名称');

            if(effectDesc === '')
                addAlert(alertDom,'无效的描述');

            $("#addEffect").attr('disabled','disabled');
            var url = '/effect/add';
            $.post(url,
                {
                    name:effectName,
                    group:effectGroup,
                    desc:effectDesc
                },
                function(res){
                var errNo = res.errNo;
                if(errNo===0)
                {
                    addAlert(alertDom,'添加成功,3秒后刷新页面','success');
                    setTimeout("location.href='/effect'",3000);
                }
                else
                {
                    $("#addEffect").removeAttr('disabled');
                    addAlert(alertDom,res.errMsg);
                }
            });
        })
    })
<?php echo '</script'; ?>
>
</html><?php }
}
