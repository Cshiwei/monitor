<?php
/**
 * Created by PhpStorm.
 * User: csw
 * Date: 2018/5/4
 * Time: 15:32
 */

$config['relation'] = array(
      'lt'  => array(
            'name' => '小于',
            'val'  => 'lt',
            'symbol' => '<',
      ),
    'gt'  => array(
        'name' => '大于',
        'val'  => 'gt',
        'symbol' => '>',
    ),
    'eq'  => array(
        'name' => '等于',
        'val'  => 'eq',
        'symbol' => '=',
    ),
    'le'  => array(
        'name' => '小于等于',
        'val'  => 'le',
        'symbol' => '<=',
    ),
    'ge'  => array(
        'name' => '大于等于',
        'val'  => 'ge',
        'symbol' => '>=',
    ),
    'ne' => array(
        'name' => '不等于',
        'val' => 'neq',
        'symbol' => '!=',
    ),
);

$config['unit'] = array(
    'one'   => array(
            'name' => '个',
            'val'  => 'one',
    ),
    'ms'   => array(
        'name' => '毫秒',
        'val'  => 'ms',
    ),
    'day' => array(
        'name' => '天',
        'val'  => 'day',
    ),
);