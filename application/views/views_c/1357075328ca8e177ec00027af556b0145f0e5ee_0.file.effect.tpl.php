<?php
/* Smarty version 3.1.32, created on 2018-05-11 10:09:24
  from 'G:\www\monitor\application\views\effect.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af4fb540cfb53_83576003',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1357075328ca8e177ec00027af556b0145f0e5ee' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\effect.tpl',
      1 => 1525922173,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/banner.tpl' => 1,
    'file:common/slidebar.tpl' => 1,
  ),
),false)) {
function content_5af4fb540cfb53_83576003 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>影响</title>
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
                <div class="col-xs-1">
                    <p><a type="button" class="btn btn-primary" href="/effect/add">添加</a></p>
                </div>
                <div  class="col-xs-9">
                    <form class="form-inline" method="get" action="/effect">
                        <div class="form-group">
                            <label class="sr-only" for="name">like:name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="norm">=:norm</label>
                            <input type="text" class="form-control" id="norm" name="norm" placeholder="norm" value="<?php echo $_smarty_tpl->tpl_vars['norm']->value;?>
">
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
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
?>
                            <tr>
                                <td></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['groupShow'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['desc'];?>
</td>
                                <td>
                                    <a class="btn btn-default btn-xs effect-norm" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" role="button" href="/effect/norm?effectId=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">指标</a>
                                    <a class="btn btn-default btn-xs edit-effect" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" href="/effect/edit?effectId=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" role="button">编辑</a>
                                    <button class="btn btn-default btn-xs del-effect" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
" role="button" data-toggle="modal" data-target="#delEffectModel">删除</button>
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
<?php echo '<script'; ?>
 src="/static/js/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/static/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    //模态框展示之后操作 将操作参数赋值到模态框
    $('#delEffectModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var name = button.data('name');
        $("#showEffect").text(name);
        $("#delEffectId").val(id);
    })
<?php echo '</script'; ?>
>
</html><?php }
}
