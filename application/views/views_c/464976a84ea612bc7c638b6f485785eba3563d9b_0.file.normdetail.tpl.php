<?php
/* Smarty version 3.1.32, created on 2018-05-11 10:02:30
  from 'G:\www\monitor\application\views\normdetail.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af4f9b6ab0733_36490411',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '464976a84ea612bc7c638b6f485785eba3563d9b' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\normdetail.tpl',
      1 => 1526004117,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/banner.tpl' => 1,
    'file:common/slidebar.tpl' => 1,
  ),
),false)) {
function content_5af4f9b6ab0733_36490411 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>编辑指标</title>

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
<small> 详情</small></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5">
                    <p>
                    <form class="form-inline" method="get" action="/norm/normDetail">
                    <input type="hidden" name="normId" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
"/>
                        <div class="form-group">
                            <label class="sr-only" for="name">time</label>
                            <input type="text" class="form-control" id="day" name="day" placeholder="day:20180510" value="">
                        </div>
                        <div class="form-group hidden">
                            <input type="submit" class="form-control" id="exampleInputPassword3" >
                        </div>
                    </form>
                    </p>
                    <table class="table table-condensed ">
                        <tbody><tr>
                            <td></td>
                            <td>序号</td>
                            <td>值</td>
                            <td>时间</td>
                        </tr>
                        </tbody><tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'val', false, 'key');
$_smarty_tpl->tpl_vars['val']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->iteration++;
$__foreach_val_1_saved = $_smarty_tpl->tpl_vars['val'];
?>
                            <tr class="<?php echo $_smarty_tpl->tpl_vars['val']->value['scene'];?>
">
                                <td></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->iteration;?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['valueShow'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['normTimeShow'];?>
</td>
                            </tr>
                        <?php
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_1_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </tbody>
                    </table>
                    <?php echo $_smarty_tpl->tpl_vars['pageShow']->value;?>

                </div>
                <div class="col-xs-7" >
                    <div id="main" style="height:400px;"></div>
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
 src="/static/js/echarts.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    <?php if ($_smarty_tpl->tpl_vars['lineChart']->value) {?>
    $(function(){
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        // 指定图表的配置项和数据
        var option = {
            xAxis: {
                type: 'category',
                data: [<?php echo $_smarty_tpl->tpl_vars['lineChart']->value['x'];?>
]
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: [<?php echo $_smarty_tpl->tpl_vars['lineChart']->value['y'];?>
],
                type: 'line',
                markLine: {
                    data: [
                        {type: 'average', name: '平均值'},
                        {name: '阈值', yAxis:<?php echo $_smarty_tpl->tpl_vars['info']->value['threshold'];?>
},
                    ]
                }
            }]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    })
    <?php }
echo '</script'; ?>
>
</html><?php }
}
