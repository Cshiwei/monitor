<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/8
 * Time: 11:52
 */
class CommonModel extends CI_Model{


    /**csw 添加操作时唯一性验证
     */
    public function addUnique($table,$field,$val)
    {
        $this->db->where(array($field=>$val));
        return $this->db->get($table)->row_array();
    }

    /**csw
     * 更新操作时唯一性验证
     */
    public function editUnique($table,$field,$val,$id)
    {
        $this->db->where(array($field=>$val));
        $this->db->where('id !=',$id);
        return $this->db->get($table)->row_array();
    }

}