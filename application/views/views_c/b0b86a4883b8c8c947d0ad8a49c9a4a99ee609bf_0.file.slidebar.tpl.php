<?php
/* Smarty version 3.1.32, created on 2018-05-11 10:09:47
  from 'G:\www\monitor\application\views\common\slidebar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af4fb6be9c640_24800219',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b0b86a4883b8c8c947d0ad8a49c9a4a99ee609bf' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\common\\slidebar.tpl',
      1 => 1525661168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5af4fb6be9c640_24800219 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="col-xs-2">
    <ul class="nav nav-pills nav-stacked">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['slidebarLink']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
?>
            <li role="presentation" class="<?php if ($_smarty_tpl->tpl_vars['active']->value == $_smarty_tpl->tpl_vars['val']->value['val']) {?>active<?php }?>"><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</a></li>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
</div><?php }
}
