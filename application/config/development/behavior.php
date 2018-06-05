<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 17:17
 */
$config['normBeyondEmail'] = array(
        'caoshiwei@lightinthebox.com',
);


//异步任务注册方式（http协议）
$config['runType'] = 'http';

$config['httpJobUrl'] = 'mymonitor.litb-test.com';
$config['httpJobPort'] = 80;

$config['taskJobUrl'] = 'monitor.litb-test.com';
$config['taskJobPort'] = 9505;
