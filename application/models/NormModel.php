<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/4
 * Time: 15:09
 */
class NormModel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function addNorm($addData)
    {
        return $this->db->insert('norm', $addData);
    }

    public function getList($where,$offset,$perPage)
    {
        //$sql  = "SELECT * FROM `{$this->db->dbprefix('norm')}` ORDER BY `updTime` DESC,`createTime` DESC";
        //$resList = $this->db->query($sql)->result_array();
        $this->db->where($where);
        $this->db->order_by('normTime','DESC');
        $this->db->limit($perPage,$offset);

        return $this->db->get('norm')->result_array();
    }

    /**csw
     * 获取指标列表数量
     */
    public function normCount($where)
    {
        $this->db->where($where);
        $this->db->from('norm');
        return $this->db->count_all_results();
    }

    /**csw
     * 删除指标 事务
     */
    public function delNormTrans($normId)
    {
        $this->db->trans_start();

        $this->db->where('id',$normId);
        $this->db->delete('norm');

        $this->db->where('normId',$normId);
        $this->db->delete('effect_norm_bind');

        return $this->db->trans_complete();
    }

    /**csw
     * 获取指标信息
     */
    public function getNormInfo($normId)
    {
        $sql = "SELECT * FROM `{$this->db->dbprefix('norm')}` where `id`='{$normId}'";
        return $this->db->query($sql)->row_array();
    }

    /**csw
     * 更新指标信息
     */
     public function editNorm($data,$conditon)
     {
         return $this->db->update('norm',$data,$conditon);
     }

     /**csw
      * 添加指标时name字段的唯一性验证
      */
     public function addNameUnique($name)
     {
         $this->load->logic('commonLogic');
         return $this->commonLogic->isUnique('norm','name',$name);
     }

     /**csw
      * 编辑指标时name字段的唯一性验证
      */
     public function editNameUnique($id,$name)
     {
         $this->load->logic('commonLogic');
         return $this->commonLogic->isUnique('norm','name',$name,$id);
     }

     /**csw
      * 批量获取norm信息
      */
     public function getNormsInfo($norms)
     {
         $this->db->where_in('id',$norms);
         return $this->db->get('norm')->result_array();
     }

     /**csw
      * 批量获取norm最近的统计信息
      */
     public function getRecentCensus($norms)
     {
         $normStr = implode(',',$norms);

         $sql = "SELECT * FROM (SELECT * FROM `{$this->db->dbprefix('norm_census')}` ORDER BY `normTime` DESC) temp
                 WHERE `normId` IN ($normStr) GROUP BY `normId`";

         return $this->db->query($sql)->result_array();
     }

    /**csw
     * 获取某个指标最近的n条统计信息
     */
    public function getNormRecentCensus($normId,$maxTime,$offset,$limit)
    {
        $sql ="SELECT * FROM `{$this->db->dbprefix('norm_census')}` WHERE `normId`='{$normId}' AND `normTime`<='{$maxTime}' ORDER BY `normTime` DESC LIMIT {$offset},{$limit}";
        return $this->db->query($sql)->result_array();
    }

     /**csw
      * 添加指标统计数据
      */
     public function addNormCensus($data)
     {
         return $this->db->insert('norm_census',$data);
     }

     public function recentCensus($normId,$number)
     {
         $sql ="SELECT a.id AS censusId,a.value AS censusValue,a.normTime AS censusTime,b.unit,b.threshold,b.relation 
                FROM `{$this->db->dbprefix('norm_census')}` a 
                LEFT JOIN `{$this->db->dbprefix('norm')}` b ON a.normId=b.id
                WHERE a.normId='{$normId}'
                ORDER BY a.normTime DESC 
                LIMIT {$number}";

         return $this->db->query($sql)->result_array();
     }

     public function normCensus($whereArr,$offset='',$limit='',$orderByArr=array())
     {
         $whereStr = $this->normCensusWhere($whereArr);
         if(empty($offset) && empty($limit))
             $limitStr = "";
         else
             $limitStr = " LIMIT {$offset},{$limit}";

         if(empty($orderByArr))
             $orderStr = ' ORDER BY `normTime` DESC';
         else
         {
             $orderStr = ' ORDER BY ';
             foreach ($orderByArr as $key=>$val)
             {
                 $orderStr.="`{$key}` {$val},";
             }
             $orderStr = trim($orderStr,',');
         }

         $sql ="SELECT * FROM `{$this->db->dbprefix('norm_census')}` 
                {$whereStr} 
                {$orderStr}
                {$limitStr}";

         return $this->db->query($sql)->result_array();
     }

     public function normCensusCount($whereArr)
     {
         $whereStr = $this->normCensusWhere($whereArr);
         $sql ="SELECT COUNT(id) as count FROM `{$this->db->dbprefix('norm_census')}` 
                {$whereStr}";

         $resCount = $this->db->query($sql)->row_array();
         return $resCount ? $resCount['count'] : 0;
     }

     public function normCensusWhere($whereArr)
     {
         if(empty($whereArr))
             return '';
         else
         {
             $where = array();
             if(isset($whereArr['day']))
             {
                 $day = $whereArr['day'];
                 $dayStamp = strtotime($day);
                 $nextDayStamp = strtotime('+1 day',$dayStamp);
                 $where[] = "`normTime` >='{$dayStamp}'";
                 $where[] = "`normTime` <='{$nextDayStamp}'";
             }

             if(isset($whereArr['normId']))
                 $where[] = "`normId`='{$whereArr['normId']}'";

             if(isset($whereArr['beginTime']))
                 $where[] = "`normTime`>='{$whereArr['beginTime']}'";

             if(isset($whereArr['endTime']))
                 $where[] = "`normTime`<='{$whereArr['endTime']}'";

             $whereStr = empty($where) ? '' : " WHERE ".implode(' AND ',$where);
         }
         return $whereStr;
     }

     public function getAllNorm()
     {
         $sql ="SELECT * FROM `{$this->db->dbprefix('norm')}` ORDER BY `name` ASC";
         return $this->db->query($sql)->result_array();
     }

     public function getNormByName($name)
     {
         $sql ="SELECT * FROM `{$this->db->dbprefix('norm')}` WHERE `name`='{$name}'";
         return $this->db->query($sql)->row_array();
     }

}