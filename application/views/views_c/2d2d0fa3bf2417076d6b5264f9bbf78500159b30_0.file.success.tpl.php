<?php
/* Smarty version 3.1.32, created on 2018-05-10 15:07:52
  from 'G:\www\monitor\application\views\common\success.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af3efc8a23710_10972378',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2d2d0fa3bf2417076d6b5264f9bbf78500159b30' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\common\\success.tpl',
      1 => 1525856255,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/banner.tpl' => 1,
  ),
),false)) {
function content_5af3efc8a23710_10972378 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>success</title>

    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <!--banner -->
    <?php $_smarty_tpl->_subTemplateRender("file:common/banner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <!--/banner-->
    <div class="row">
        <div class="col-xs-offset-1 col-xs-8">
            <div class="jumbotron">
                <h2>success!</h2>
                <p>操作成功：<?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</p>
                <p><span id="stay"></span>秒后跳转</p>
                <p><a class="btn btn-primary btn-lg" href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" role="button">返回</a></p>
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
>
    $(function() {
        function showTime(count) {
            document.getElementById('stay').innerHTML = count;
            if (count == 0) {
                location.href = '<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
';
            } else {
                count -= 1;
                setTimeout(function () {
                    showTime(count);
                }, 1000);
            }
        }
        showTime(<?php echo $_smarty_tpl->tpl_vars['stay']->value;?>
);
    })
<?php echo '</script'; ?>
>
</html><?php }
}
