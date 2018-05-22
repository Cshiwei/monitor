<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 18:41
 */
$config['jobType'] = array(
    '1' => array(
        'name' => '方法',
        'list' => 'Method',
        'val' => 1,
    ),
   /* '2' => array(
        'name' => '脚本',
        'list' => 'Script',
        'val' => 2,
    )*/
);

$config['behaviorType'] = array(
    '1' => array(
        'name' => '系统',
        'val' => 1,
        'desc' => '行为对所有item生效',
        'default' => 0,
    ),
    '2' => array(
        'name' => '自定义',
        'val' => 2,
        'desc' => '仅对指定item生效',
        'default' => 1,
    ),
);

$config['status'] = array(
    0  => array(
        'name' => '禁用中',
        'val' => 0,
    ),
    1 => array(
        'name' => '已启用',
        'val' => 1,
    ),
);


$config['trigger'] = array(
    1 => array(
        'name' => '接收到指标数据',
        'val' => 1,
        'desc' => '只要接口接收到请求就触发',
    ),
    2 => array(
        'name' => '成功添加指标数据',
        'val'  => 2,
        'desc' => '成功将指标数据存入数据库',
    ),
    3 => array(
        'name' => '添加指标数据失败',
        'val' => 3,
        'desc' => '未成功将指标数据存入数据库',
    ),
    4 => array(
        'name' => '指标数据正常',
        'val' => 4,
        'desc' => '指标数据正常，未超出阈值',
    ),
    5 => array(
        'name' => '超出阈值',
        'val' => 5,
        'desc' => '指标数据超出阈值',
    ),
);





