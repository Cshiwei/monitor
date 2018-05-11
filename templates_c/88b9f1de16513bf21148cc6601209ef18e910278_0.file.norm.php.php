<?php
/* Smarty version 3.1.32, created on 2018-05-04 17:10:09
  from 'G:\www\monitor\application\views\norm.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5aec23715dfd17_40443115',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '88b9f1de16513bf21148cc6601209ef18e910278' => 
    array (
      0 => 'G:\\www\\monitor\\application\\views\\norm.php',
      1 => 1525422442,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5aec23715dfd17_40443115 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>指标</title>

    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <?php echo '<script'; ?>
 src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
</head>
<body>
<div class="container-fluid">
<div class="row">
    <nav class="navbar navbar-default  col-xs-12">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Monitor</a>
        </div>
    </nav>
</div>
<div class="row">
    <div class="col-xs-2">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation" class="active"><a href="#">指标</a></li>
            <li role="presentation"><a href="#">影响</a></li>
        </ul>
    </div>
    <div class="col-xs-9">
        <p>
            <a type="button" class="btn btn-primary" href="/norm/addnorm">添加</a>
        </p>
        <table class="table table-condensed">
            <th>
            <td>ID</td>
            <td>阈值</td>
            <td>名称</td>
            <td>描述</td>
            <td>操作</td>
            </th>
            <tbody>
            <tr>
                <td></td>
                <td>1</td>
                <td>>=100</td>
                <td>库存数量</td>
                <td>库存数量</td>
                <td>
                    <a class="btn btn-default btn-xs" href="#" role="button">影响</a>
                    <a class="btn btn-default btn-xs" href="#" role="button">编辑</a>
                    <a class="btn btn-default btn-xs" href="#" role="button">删除</a>
                </td>
            </tr>
            <tr>
                <?php echo '<?php ';?>foreach ($relation as $item): <?php echo '?>';?>
                    <li><?php echo '<?=';?>$item<?php echo '?>';?></li>
                <?php echo '<?php ';?>endforeach; <?php echo '?>';?>
            </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li>
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
</div>
<?php echo '<script'; ?>
 src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"><?php echo '</script'; ?>
>
</body>
</html><?php }
}
