<?php
/* Smarty version 3.1.32, created on 2018-05-11 09:52:08
  from 'G:\www\monitor\application\views\normmodel.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af4f7485c4501_87309125',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'be36481e3e0efd5327d92d253d89a0b9e500ffb9' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\normmodel.tpl',
      1 => 1525951434,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5af4f7485c4501_87309125 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">详情</h4>
</div>
<div class="modal-body">
    <h4><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h4>
    <p>阈值：<?php echo $_smarty_tpl->tpl_vars['info']->value['thresholdShow'];?>
</p>
    <p>描述：<?php echo $_smarty_tpl->tpl_vars['info']->value['desc'];?>
</p>
    <hr/>
    <p>最近数据</p>
    <table class="table table-condensed ">
        <tr>
            <td></td>
            <td>序号</td>
            <td>值</td>
            <td>时间</td>
        </tr>
        <tbody>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'val');
$_smarty_tpl->tpl_vars['val']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->iteration++;
$__foreach_val_0_saved = $_smarty_tpl->tpl_vars['val'];
?>
                <tr class="<?php echo $_smarty_tpl->tpl_vars['val']->value['scene'];?>
">
                    <td></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['val']->iteration;?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['thresholdShow'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['normTimeShow'];?>
</td>
                </tr>
            <?php
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_0_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    <a href="/norm/normDetail?normId=<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
" type="button" class="btn btn-primary">详情</a>
</div><?php }
}
