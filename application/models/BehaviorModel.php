<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 18:39
 */
class BehaviorModel extends CI_Model{

    static $TASK_TYPE_EMAIL=1;
    public function addBehavior($name,$desc,$normId,$taskType,$taskParam)
    {
        $now = time();
        $this->db->trans_begin();
        $data = array(
            'name' => $name,
            'desc' => $desc,
            'normId' => $normId,
            'trigger' => 5,
            'taskType' => $taskType,
            'createTime' => $now,
            'updTime' => $now,
        );
        $resAddBehavior = $this->db->insert('behavior',$data);

        if($resAddBehavior)
        {
            $behaviorId = $this->db->insert_id();
            switch($taskType)
            {
                case self::$TASK_TYPE_EMAIL :
                    $data = array(
                        'behaviorId' => $behaviorId,
                        'title' => "【Monitor】 ".$taskParam['emailTitle'],
                        'emailTo'   => $taskParam['emailTo'],
                        'content' => $taskParam['emailContent'],
                    );
                    $resAddTask = $this->db->insert('task_email',$data);
                    break;
                default :
                    break;
            }

            if($resAddTask)
            {
                $this->db->trans_commit();
                return true;
            }
        }

        $this->db->trans_rollback();
        return false;
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

    public function getTaskInfo($behaviorId,$taskType)
    {
        $taskTb = $this->getTaskTab($taskType);
        $sql = "SELECT * FROM `{$this->db->dbprefix($taskTb)}` WHERE `behaviorId`='{$behaviorId}'";
        return $this->db->query($sql)->row_array();
    }

    public function updBehavior($id,$name,$desc,$normId,$taskType,$taskParam)
    {
        $this->db->trans_start();
        $data = array(
            'name' => $name,
            'desc' => $desc,
            'normId' => $normId,
            'taskType' => $taskType,
            'status' => 0,
            'updTime' => time(),
        );
        $this->db->update('behavior',$data,array('id'=>$id));

        switch($taskType)
        {
            case self::$TASK_TYPE_EMAIL :
                $data = array(
                    'title' => '【Monitor】 '.$taskParam['emailTitle'],
                    'emailTo'   => $taskParam['emailTo'],
                    'content' => $taskParam['emailContent'],
                );
                $this->db->update('task_email',$data,array('behaviorId'=>$id));
                break;
            default :
                break;
        }
        return $this->db->trans_complete();
    }

    public function editNameUnique($id,$name)
    {
        $this->load->logic('commonLogic');
        return $this->commonLogic->isUnique('behavior','name',$name,$id);
    }

    public function delBehaviorTrans($id,$taskType)
    {
        $this->db->trans_start();

        $this->db->where('id',$id);
        $this->db->delete('behavior');

        $taskTb = $this->getTaskTab($taskType);

        $this->db->where('behaviorId',$id);
        $this->db->delete($taskTb);

        return $this->db->trans_complete();
    }

    public function getTaskTab($taskType)
    {
        switch($taskType)
        {
            case self::$TASK_TYPE_EMAIL :
                $taskTb = 'task_email';
                break;
            default :
                $taskTb = '';
        }
        return $taskTb;
    }

    public function getBehaviorByNormId($normId)
    {
        $sql ="SELECT * FROM `{$this->db->dbprefix('behavior')}` WHERE `normId`={$normId} AND `status`=1";
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

    public function addJob($data)
    {
        $resAdd = $this->db->insert('job',$data);
        if($resAdd)
            return $this->db->insert_id();

        return $resAdd;
    }

    public function getJobInfo($jobId)
    {
        $sql = "SELECT * FROM `{$this->db->dbprefix('job')}` WHERE `id`='{$jobId}'";
        return $this->db->query($sql)->result_row();
    }
}