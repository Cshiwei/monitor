<?php
/* Smarty version 3.1.32, created on 2018-05-10 19:26:17
  from 'G:\www\monitor\application\views\effectaddnorm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af42c594797f0_62078742',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f407bd1e18011ed71ff1175d32d475fc413c3a32' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\effectaddnorm.tpl',
      1 => 1525859349,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/banner.tpl' => 1,
    'file:common/slidebar.tpl' => 1,
  ),
),false)) {
function content_5af42c594797f0_62078742 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>影响-添加指标</title>

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
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-header">
                        <h4><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
<small> 添加指标</small></h4>
                    </div>
                </div>
            </div>
            <form class="form-horizontal" id="addNormFm" name="addNormFm" method="post" action="/effect/addNorm">
                <input type="hidden" name="action" value="doAdd"/>
                <input type="hidden" name="effectId" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
"/>
                <div class="form-group">
                    <div class="col-xs-12">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
?>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="normCheck" name="normCheck[]" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"> <?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>

                            </label>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-xs-12">
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-10">
                    <button type="button" id="doAddNorm" disabled="disabled" class="btn btn-primary">添加</button>
                    <a class="btn btn-primary btn-sm" href="/effect/norm?effectId=<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
">返回</a>
                </div>
            </div>
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
    //判断添加按钮是否可点击
    $(function(){
        var checkboxes = $(".normCheck"),
            submitButt = $("#doAddNorm");

            checkboxes.click(function() {
            submitButt.attr("disabled", !checkboxes.is(":checked"));
        });
    })
    //点击添加
    $(function(){
        $("#doAddNorm").click(function(){
            $('#addNormFm').submit();
        })
    })
<?php echo '</script'; ?>
>
</html><?php }
}
