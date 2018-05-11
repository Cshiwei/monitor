<?php
/* Smarty version 3.1.32, created on 2018-05-09 17:21:13
  from 'G:\www\monitor\application\views\addnorm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af2bd8925d788_94984591',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b860f4f45d27ee1ee44e07bdcb4718835188538b' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\addnorm.tpl',
      1 => 1525857005,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/banner.tpl' => 1,
    'file:common/slidebar.tpl' => 1,
  ),
),false)) {
function content_5af2bd8925d788_94984591 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加指标</title>

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
            <form class="form-horizontal" name="addNorm" method="post">
                <div class="form-group">
                    <label for="normName" class="col-sm-2 control-label">指标名称</label>
                    <div class="col-xs-5">
                        <input type="text" id="normName" name="normName" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="normDesc" class="col-sm-2 control-label">描述</label>
                    <div class="col-xs-10">
                        <textarea name="normDesc" class="form-control" id="normDesc" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="normRelation" class="col-sm-2 control-label">阈值</label>
                    <div class="col-xs-2">
                        <select id="normRelation" name="normRelation" class="form-control">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['relationArr']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['val'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <input type="text" id="normThreshold" name="normName" class="form-control" placeholder="1000">
                    </div>
                    <div class="col-xs-2">
                        <select id="normUnit" name="normUnit" class="form-control">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['unitArr']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['val'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" id="addNorm" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
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
    //点击提交按钮检测表单数据是否合法
        $('#addNorm').click(function(){
            var normName = $('#normName').val();
            var normDesc = $('#normDesc').val();
            var normRelation = $('#normRelation').val();
            var normThreshold = $('#normThreshold').val();
            var normUnit = $('#normUnit').val();
            var alertObj = $('#alertDom');

            if(normName === '')
            {
                $('#normName').focus();
                addAlert(alertObj,'请输入指标名称','danger');
                return false;
            }

            if(normDesc === '')
            {
                $('#normDesc').focus();
                addAlert(alertObj,'请输入描述');
                return false;
            }

            if(normThreshold === '')
            {
                $('#normThreshold').focus();
                addAlert(alertObj,'请输入阈值');
                return false;
            }

            if(normUnit === '')
            {
                $('#normUnit').focus();
                addAlert(alertObj,'请输入阈值单位');
                return false;
            }
            $("#addNorm").attr('disabled','disabled');
            var url = "/norm/addNorm"
            $.post(url,
                {
                    normName:normName,
                    normDesc:normDesc,
                    normRelation:normRelation,
                    normThreshold:normThreshold,
                    normUnit:normUnit
                },
                function (res) {
                    var errNo = res.errNo;
                    if(errNo===0)
                    {
                        addAlert(alertObj,'添加成功,2秒后刷新页面','success');
                        setTimeout("location.href='/norm'",2000);
                    }
                    else
                    {
                        $("#addNorm").removeAttr('disabled');
                        addAlert(alertObj,res.errMsg);
                    }
                }
            )
        })
<?php echo '</script'; ?>
>
</body>
</html><?php }
}
