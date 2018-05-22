<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 18:39
 */
class BehaviorModel extends CI_Model{

    public function addBehavior($data)
    {
        return $this->db->insert('behavior',$data);
    }

    public function addNameUnique($name)
    {
        $this->load->logic('commonLogic');
        return $this->commonLogic->isUnique('behavior','name',$name);
    }

    public function behaviorCount($whereArr)
    {
        $whereStr = $this->behaviorWhere($whereArr);
        $sql ="SELECT COUNT(*) as count FROM `{$this->db->dbprefix('behavior')}` 
                {$whereStr}";

        $resCount = $this->db->query($sql)->row_array();
        return isset($resCount['count']) ? $resCount['count'] : false;
    }

    public function behaviorList($whereArr,$offset='',$limit='',$orderByArr=array('updTime'=>'DESC'))
    {
        $this->load->library('Querybuilder');
        $whereStr = $this->behaviorWhere($whereArr);

        $limitStr = $this->querybuilder->limit($offset,$limit)->getStr('limit');
        $orderStr = $this->querybuilder->order_by($orderByArr)->getStr('order');

        $sql ="SELECT * FROM `{$this->db->dbprefix('behavior')}` 
                {$whereStr} 
                {$orderStr}
                {$limitStr}";

        return $this->db->query($sql)->result_array();
    }

    public function behaviorWhere($whereArr)
    {
        if(empty($whereArr))
            return '';
    }

    public function getInfo($behaviorId)
    {
        $sql = "SELECT * FROM `{$this->db->dbprefix('behavior')}` WHERE `id`='{$behaviorId}'";
        return $this->db->query($sql)->row_array();
    }

    public function updBehavior($id,$data)
    {
        return $this->db->update('behavior',$data,array('id'=>$id));
    }

    public function editNameUnique($id,$name)
    {
        $this->load->logic('commonLogic');
        return $this->commonLogic->isUnique('behavior','name',$name,$id);
    }

    public function delBehaviorTrans($id)
    {
        $this->db->trans_start();

        $this->db->where('id',$id);
        $this->db->delete('behavior');

        return $this->db->trans_complete();
    }

    public function getBehaviorByNormId($normId)
    {
        $sql ="SELECT * FROM `{$this->db->dbprefix('behavior')}` WHERE `behaviorType`=2 AND `normId`={$normId} AND `status`=1";
        return $this->db->query($sql)->result_array();
    }

    public function getSysBehavior()
    {
        $sql ="SELECT * FROM `{$this->db->dbprefix('behavior')}` WHERE `behaviorType`=1 AND `status`=1";
        return $this->db->query($sql)->result_array();
    }

    public function enableBehavior($id)
    {
        $data = array(
            'status' => 1,
        );
        return $this->db->update('behavior',$data,array('id'=>$id));
    }

    public function disabledBehavior($id)
    {
        $data = array(
            'status' => 0,
        );
        return $this->db->update('behavior',$data,array('id'=>$id));
    }

    public function beginTaskLog($data)
    {
        $res = $this->db->insert('task_log',$data);
        if($res)
            return $this->db->insert_id();

        return false;
    }

    public function endTaskLog($logId,$data)
    {
        $this->db->update('task_log',$data,array('id'=>$logId));
    }
}