<?php
/* Smarty version 3.1.32, created on 2018-05-11 15:26:58
  from 'G:\www\monitor\application\views\norm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af545c2ad97d8_91194783',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '613fddefbf661a1824bbd3bd5fcd02243a7bee9e' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\norm.tpl',
      1 => 1525945406,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/banner.tpl' => 1,
    'file:common/slidebar.tpl' => 1,
  ),
),false)) {
function content_5af545c2ad97d8_91194783 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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
    <?php $_smarty_tpl->_subTemplateRender("file:common/banner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <!--/banner-->
<div class="row">
    <!--slidebar-->
    <?php $_smarty_tpl->_subTemplateRender("file:common/slidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
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
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
?>
                <tr class="<?php echo $_smarty_tpl->tpl_vars['val']->value['scene'];?>
">
                    <td></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['thresholdShow'];?>
</td>
                    <td class="td-hidden"><?php echo $_smarty_tpl->tpl_vars['val']->value['desc'];?>
</td>
                    <td>
                    <!--
                    <a class="btn btn-default btn-xs effect-norm" href="/effect?norm=<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" role="button">影响</a>
                    -->
                    <a class="btn btn-default btn-xs" href="/norm/normDetail?normId=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" role="button">详情</a>
                    <a class="btn btn-default btn-xs edit-norm" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" href="/norm/editNorm?normId=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" role="button">编辑</a>
                    <button class="btn btn-default btn-xs del-norm" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
" role="button" data-toggle="modal" data-target="#delNormModel">删除</button>
                    </td>
                </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <?php echo $_smarty_tpl->tpl_vars['pageShow']->value;?>

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
<?php echo '<script'; ?>
 src="/static/js/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/static/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    //模态框展示之后操作 将操作参数赋值到模态框
    $('#delNormModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var name = button.data('name');
        $("#delNormId").val(id);
        $("#showNorm").text(name);
    })
<?php echo '</script'; ?>
>
</body>
</html><?php }
}
