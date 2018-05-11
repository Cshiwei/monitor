<?php
/**
 * Created by PhpStorm.
 * User: csw
 * Date: 2018/5/7
 * Time: 18:26
 */

class EffectModel extends CI_Model{

    public function addEffect($data)
    {
        return $this->db->insert('effect',$data);
    }



    public function getList($whereArr,$offset,$perPage)
    {
        $whereStr = $this->getEffectWhereStr($whereArr);
        $sql = "SELECT a.id,a.name,a.desc,b.id AS bindId,b.normId AS normId,c.name as normName,d.id as groupId,d.name as groupName FROM `{$this->db->dbprefix('effect')}` a
                LEFT JOIN `{$this->db->dbprefix('effect_norm_bind')}` b ON a.id=b.effectId
                LEFT JOIN `{$this->db->dbprefix('norm')}` c ON b.normId=c.id
                LEFT JOIN `{$this->db->dbprefix('effect_group')}` d ON a.groupId= d.id
                {$whereStr}
                GROUP BY a.id
                LIMIT {$offset},{$perPage}";

        return $this->db->query($sql)->result_array();
    }

    public function getEffectWhereStr($whereArr)
    {
        if(empty($whereArr))
            $whereStr = '';
        else
        {   $where = array();
            empty($whereArr['name']) or $where[] = "a.name like '%{$whereArr['name']}%'";
            empty($whereArr['norm']) or $where[] = "c.name='{$whereArr['norm']}'";

            $whereStr =' WHERE '.implode(' AND ',$where);
        }

        return $whereStr;
    }

    /**csw
     * 获取影响列表数量
     */
    public function effectCount($whereArr)
    {
        $whereStr = $this->getEffectWhereStr($whereArr);
        $sql = "SELECT a.id,a.name,a.desc,b.id AS bindId,b.normId AS normId,c.name as normName,d.id as groupId,d.name as groupName FROM `{$this->db->dbprefix('effect')}` a
                LEFT JOIN `{$this->db->dbprefix('effect_norm_bind')}` b ON a.id=b.effectId
                LEFT JOIN `{$this->db->dbprefix('norm')}` c ON b.normId=c.id
                LEFT JOIN `{$this->db->dbprefix('effect_group')}` d ON a.groupId= d.id
                {$whereStr}
                GROUP BY a.id
                ";
        return count($this->db->query($sql)->result_array());
    }

    public function delEffect($effectId)
    {
        return $this->db->delete('effect',array('id'=>$effectId));
    }


    /**csw
     * 删除影响 事务
     */
    public function delEffectTrans($effectId)
    {
        $this->db->trans_start();

        $this->db->where('id',$effectId);
        $this->db->delete('effect');

        $this->db->where('effectId',$effectId);
        $this->db->delete('effect_norm_bind');

        return $this->db->trans_complete();
    }

    /**csw
     * 获取影响分组列表
     */
    public function groupList($where,$offset,$perPage)
    {
        $this->db->where($where);
        $this->db->order_by('updTime','DESC');
        $this->db->limit($perPage,$offset);
        return $this->db->get('effect_group')->result_array();
    }

    public function groupCount($where)
    {
        $this->db->where($where);
        $this->db->from('effect_group');
        return $this->db->count_all_results();
    }

    public function addGroup($data)
    {
        return $this->db->insert('effect_group',$data);
    }

    public function nameUnique($name)
    {
        $this->load->logic('commonLogic');
        return $this->commonLogic->isUnique('effect_group','name',$name);
    }

    public function groupInfo($groupId)
    {
        $this->db->where(array('id'=>$groupId));
        return $this->db->get('effect_group')->row_array();
    }

    public function nameEditUnique($id,$name)
    {
        $this->load->logic('commonLogic');
        return $this->commonLogic->isUnique('effect_group','name',$name,$id);
    }

    public function updGroup($id,$data)
    {
        return $this->db->update('effect_group',$data,array('id'=>$id));
    }

    public function getEffectByGroup($groupId)
    {
        $this->db->where(array('groupId'=>$groupId));
        return $this->db->get('effect')->result_array();
    }

    public function delGroup($groupId)
    {
        return $this->db->delete('effect_group',array('id'=>$groupId));
    }

    public function effectInfo($effectId)
    {
        $this->db->where(array('id'=>$effectId));
        return $this->db->get('effect')->row_array();
    }

    public function effectNameUnique($name)
    {
        $this->load->logic('commonLogic');
        return $this->commonLogic->isUnique('effect','name',$name);
    }

    public function editEffectNameUnique($id,$name)
    {
        $this->load->logic('commonLogic');
        return $this->commonLogic->isUnique('effect','name',$name,$id);
    }

    public function updEffect($id,$data)
    {
        return $this->db->update('effect',$data,array('id'=>$id));
    }

    public function getNoBindNorm($effectId)
    {
        $sql ="SELECT * FROM `{$this->db->dbprefix('norm')}` 
         WHERE `id` NOT IN (SELECT `normId` FROM `{$this->db->dbprefix('effect_norm_bind')}` WHERE `effectId`='{$effectId}')";

        return $this->db->query($sql)->result_array();
    }

    public function getBindNorm($effectId)
    {
        /*$sql ="SELECT b.id,b.name,b.desc,a.effectId,c.name FROM `{$this->db->dbprefix('effect_norm_bind')}` a
               LEFT JOIN `{$this->db->dbprefix('norm')}` b ON a.normId=b.id 
               LEFT JOIN `{$this->db->dbprefix('effect')}` c ON a.effectId=c.id WHERE a.effectId='{$effectId}'";*/
        $sql = "SELECT b.id,b.name,b.desc,b.unit,b.relation,b.threshold FROM `{$this->db->dbprefix('effect_norm_bind')}` a
               LEFT JOIN `{$this->db->dbprefix('norm')}` b ON a.normId=b.id  WHERE a.effectId='{$effectId}'";

        return $this->db->query($sql)->result_array();
    }

    public function addNorms($effectId,$norms)
    {
        $data = array();
        $now = time();
        foreach ($norms as $key=>$val)
        {
            $data[]=array(
                'effectId' => $effectId,
                'normId' => $val,
                'createTime' => $now,
                'updTime' => $now,
            );
        }

        return $this->db->insert_batch('effect_norm_bind',$data);
    }

    public function delNorm($effectId,$normId)
    {
        $this->db->where(array('effectId'=>$effectId));
        $this->db->where(array('normId'=>$normId));
        return $this->db->delete('effect_norm_bind');
    }
}