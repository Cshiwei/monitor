<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 18:41
 */
$config['type'] = array(
    '1' => array(
        'name' => '控制器-方法',
        'list' => 'Method',
        'val' => 1,
    ),
   /* '2' => array(
        'name' => '脚本',
        'list' => 'Script',
        'val' => 2,
    )*/
);

$config['triggerType'] = array(
    '1' => array(
          'name' => '指标',
          'val' => 1,
      ),
    '2' => array(
        'name' => '影响',
        'val' => 2,
    ),
    '3' => array(
        'name' => '手动',
        'val' => 3,
    ),
);

$config['trigger'] = array(
    1 => array(
        'name' => '指标超出阈值',
        'val' => 1,
        'desc' => '指标超出阈值，即触发行为',
        'type' => 1,
    ),
    2 => array(
        'name' => '添加指标数据失败',
        'val'  => '2',
        'desc' => '成功调用接口，但并未成功将数据存入数据库',
        'type' => 1,
    ),
    3 => array(
        'name' => '其中一个指标超出阈值',
        'val' => '1',
        'desc' => '某个影响中仅有一个指标超出阈值',
        'type' => 2,
    ),
    4 => array(
        'name' => '所有指标超出阈值',
        'val' => '2',
        'desc' => '某个影响所有指标都超出阈值',
        'type' => 2,
    ),
    5 => array(
        'name' => '手动',
        'val' => '2',
        'desc' => '手动执行某个任务',
        'type' => 3,
    )
);



