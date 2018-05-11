<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/10
 * Time: 13:37
 */
/**csw
 * 比较两个数的关系
 */
if(!function_exists('data_compare'))
{
    function data_compare($a,$symbol,$b)
    {
        $compare = '';
        switch($symbol)
        {
            case 'lt' :
                $compare = $a < $b;
                break;
            case 'gt' :
                $compare = $a > $b;
                break;
            case 'eq' :
                $compare = $a = $b;
                break;
            case 'neq' :
                $compare = $a != $b;
                break;
            case 'le' :
                $compare = $a <= $b;
                break;
            case 'ge' :
                $compare = $a >= $b;
                break;
            default :
                $compare = 'error';
        }
        return $compare;
    }
}