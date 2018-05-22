<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/7
 * Time: 10:12
 */
//侧边栏配置
$config['slidebarLink'] = array(
    'norm' => array(
        'name' => '指标',
        'val'  => 'norm',
        'link' => '/norm',
    ),
    'effect' => array(
        'name' => '影响',
        'val'  => 'effect',
        'link' => '/effect',
    ),
    'group' => array(
        'name' => '分组',
        'val' => 'group',
        'link' => '/group',
    ),
    'behavior' => array(
        'name' => '行为',
        'val'  => 'behavior',
        'link' => '/behavior'
    ),
);
//控制侧边栏当前的选中栏目
$config['slidebarActive'] = array(
    'norm' => array(
        'controller' => 'norm',
        'active'  => 'norm',
    ),
    'effect' => array(
        'controller' => 'effect',
        'active' => 'effect',
    ),
    'group' => array(
        'controller' => 'group',
        'active' => 'group',
    ),
    'behavior' => array(
        'controller' => 'behavior',
        'active' => 'behavior'
    ),
);

