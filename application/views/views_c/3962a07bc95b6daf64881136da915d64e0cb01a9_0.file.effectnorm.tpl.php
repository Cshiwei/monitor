<?php
/* Smarty version 3.1.32, created on 2018-05-11 09:52:06
  from 'G:\www\monitor\application\views\effectnorm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af4f746e5b369_57209774',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3962a07bc95b6daf64881136da915d64e0cb01a9' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\effectnorm.tpl',
      1 => 1525940224,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/banner.tpl' => 1,
    'file:common/slidebar.tpl' => 1,
  ),
),false)) {
function content_5af4f746e5b369_57209774 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>影响-指标</title>

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
<small> 指标</small></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if ($_smarty_tpl->tpl_vars['list']->value) {?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
?>
                        <div class="col-xs-3 norm-panel">
                            <div class="panel panel-<?php echo $_smarty_tpl->tpl_vars['val']->value['panelType'];?>
">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>

                                        <button type="button" data-effectId="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
" data-normId="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" class="close del-norm" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </h3>
                                </div>
                                <div class="panel-body normDetail" style="cursor:pointer" data-normId="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['recentValShow'];?>

                                    <span class="glyphicon glyphicon-option-horizontal pull-right" aria-hidden="true" ></span>
                                </div>
                            </div>
                        </div>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                <?php }?>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-10">
                    <a type="button" href="/effect/addNorm?effectId=<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
" class="btn btn-primary">添加</a>
                    <a type="button" href="/effect" class="btn btn-primary">返回</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--模态框-->
<!-- Modal -->
<div class="modal fade" id="normMoreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<!--/模态框-->
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
       //点击删除指标
        $(".del-norm").click(function(){
            var parentPanel = $(this).parents(".norm-panel");
            var normId = $(this).attr('data-normId');
            var effectId = $(this).attr('data-effectId');
            var url = '/effect/delNorm';
            $.post(url,{effectId:effectId,normId:normId},function(res){
                if(res.errNo===0){
                    parentPanel.remove();
                }else{
                    myAlert('删除失败！');
                }
            })
        })
   })

    $(function(){
        $(".normDetail").click(function(){
            var url = '/effect/normRecent';
            var normId = $(this).attr('data-normId');
            $.post(url,{normId:normId},function(res){
                if(res.errNo===0){
                    $('#normMoreModal .modal-content').html(res.result.html);
                    $('#normMoreModal').modal('show');
                }else{
                    myAlert(res.errMsg);
                }
            })
        })
    })
<?php echo '</script'; ?>
>
</html><?php }
}
