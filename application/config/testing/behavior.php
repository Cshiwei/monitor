<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 17:18
 */
$config['beyondNormEmail'] = array(
    'caoshiwei@lightinthebox.com',
);
$config['baseUrl'] = 'monitor.litb-test.com';

//异步任务的注册方式（swoole task）
$config['runType'] = 'task';

$config['httpJobUrl'] ='monitor.litb-test.com';
$config['httpJobPort'] = 9501;

$config['taskJobUrl'] = 'monitor.litb-test.com';
$config['taskJobPort'] = 9505;