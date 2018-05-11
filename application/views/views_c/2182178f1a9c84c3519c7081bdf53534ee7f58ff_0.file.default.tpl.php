<?php
/* Smarty version 3.1.32, created on 2018-05-11 10:02:30
  from 'G:\www\monitor\application\views\common\page\default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af4f9b6a3f290_89684786',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2182178f1a9c84c3519c7081bdf53534ee7f58ff' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\common\\page\\default.tpl',
      1 => 1525751284,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5af4f9b6a3f290_89684786 (Smarty_Internal_Template $_smarty_tpl) {
?><nav aria-label="Page navigation">
    <ul class="pagination">
        <?php if ($_smarty_tpl->tpl_vars['linkArr']->value['firstLink']) {?>
            <li>
                <a href="<?php echo $_smarty_tpl->tpl_vars['linkArr']->value['firstLink'];?>
" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['linkArr']->value['commonLink']) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['linkArr']->value['commonLink'], 'val', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
" > <?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 </a></li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['linkArr']->value['lastLink']) {?>
            <li>
                <a href="<?php echo $_smarty_tpl->tpl_vars['linkArr']->value['lastLink'];?>
" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php }?>
    </ul>
</nav><?php }
}
