<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 17:17
 */

$config['normBeyondEmail'] = array(
    'caoshiwei@lightinthebox.com',
    'xinhailong@lightinthebox.com'
);

$config['baseUrl'] = 'monitor.tbox.me';


//异步任务的注册方式（swoole task）
$config['runType'] = 'task';
$config['httpJobUrl'] ='monitor.tbox.me';
$config['httpJobPort'] = 9501;

$config['taskJobUrl'] = 'monitor.tbox.me';
$config['taskJobPort'] = 9505;