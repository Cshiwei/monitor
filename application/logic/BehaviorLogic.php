<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 18:23
 */
class BehaviorLogic extends CI_Logic{

    static $BEHAVIOR_TYPE_SYS = 1;
    static $BEHAVIOR_TYPE_CUSTOMIZE = 2;


    public function addBehavior($name,$behaviorType,$trigger,$normId,$jobType,$jobName,$desc)
    {
        $this->load->model('behaviorModel');
        $this->load->model('normModel');

        if(empty($name))
            return $this->returnMsg(101,'无效的行为名称');

        if(!$this->behaviorModel->addNameUnique($name))
            return $this->returnMsg(102,'该名称已被占用');

        if(!$this->confirmBehaviorType($behaviorType))
            return $this->returnMsg(103,'无效的行为类型');

        if(!$this->confirmTrigger($trigger))
            return $this->returnMsg(104,'无效的触发条件');

        if($behaviorType == self::$BEHAVIOR_TYPE_CUSTOMIZE)
        {
            $resNorm = $this->normModel->getNormInfo($normId);
            if(!$resNorm)
                return $this->returnMsg(105,'无效的指标');
        }

        if(!$this->confirmJobType($jobType))
            return $this->returnMsg(106,'无效的任务类型');

        if(empty($jobName))
            return $this->returnMsg(107,'无效的任务');

        if(empty($desc))
            return $this->returnMsg(108,'无效的描述');

        $now = time();
        $data = array(
            'name' => $name,
            'behaviorType' => $behaviorType,
            'trigger' => $trigger,
            'jobType' => $jobType,
            'jobName' => $jobName,
            'desc' => $desc,
            'createTime' => $now,
            'updTime' => $now,
        );

        if($behaviorType == self::$BEHAVIOR_TYPE_CUSTOMIZE)
            $data['normId'] = $normId;

        $resAdd = $this->behaviorModel->addBehavior($data);

        if(!$resAdd)
            return $this->returnMsg(106,'添加失败');

        return $this->returnMsg(0);
    }

    public function confirmTrigger($trigger)
    {
        $this->config->load('behavior');
        $triggerArr = $this->config->item('trigger');

        return array_key_exists($trigger,$triggerArr);
    }

    /**csw
     * 验证type是否合法
     * @param $type
     * @return bool
     */
    public function confirmJobType($type)
    {
        $this->config->load('behavior');
        $typeArr = $this->config->item('jobType');

        return array_key_exists($type,$typeArr);
    }

    public function confirmBehaviorType($behaviorType)
    {
        $this->config->load('behavior');
        $behaviorTypeArr = $this->config->item('behaviorType');

        return array_key_exists($behaviorType,$behaviorTypeArr);
    }

    /**csw
     * 获取行为列表信息
     */
    public function behaviorList($pageNum)
    {
        $this->load->model('behaviorModel');

        $pageNum = intval($pageNum) <= 0 ? 1 : $pageNum;
        $perPage = 10;
        $offset = $this->getOffset($pageNum,$perPage);

        $where = array();

        $resCount = $this->behaviorModel->behaviorCount($where);
        $resList = $this->behaviorModel->behaviorList($where,$offset,$perPage);

        $pageShow = $this->getPageShow("/behavior",$resCount,$pageNum,$perPage);

        if(!$resList)
            return $this->returnMsg(101,'未获取到列表信息');

        foreach ($resList as $key=>$val)
        {
            $resList[$key]['jobNameShow'] = $this->jobShow($val['jobType'],$val['jobName']);
            $resList[$key]['statusShow'] = $this->statusShow($val['status']);
        }

        $res = array(
            'count' => $resCount,
            'list' => $resList,
            'pageShow' => $pageShow,
        );
        return $this->returnMsg(0,$res);
    }

    public function statusShow($status)
    {
        $this->config->load('behavior');
        $statusArr = $this->config->item('status');

        return isset($statusArr[$status]) ? $statusArr[$status]['name'] : '';
    }

    public function jobShow($type,$jobName)
    {
         $this->config->load('behavior');
         $typeArr = $this->config->item('type');
         return isset($typeArr[$type]) ? "{$typeArr[$type]['list']}-{$jobName}" : $jobName;
    }

    public function getInfo($behaviorId)
    {
        $this->load->model('behaviorModel');
        $this->load->model('normModel');
        if(empty($behaviorId))
            return $this->returnMsg(101,'无效的行为ID');

        $resInfo = $this->behaviorModel->getInfo($behaviorId);

        if(!$resInfo)
            return $this->returnMsg(102,'未获取到行为信息');

        if($resInfo['normId'])
        {
            $resNormInfo = $this->normModel->getNormInfo($resInfo['normId']);
            $resInfo['norm'] = $resNormInfo ? $resNormInfo['name'] : '';
        }

        $resInfo['behaviorTypeShow'] = $this->behaviorTypeShow($resInfo['behaviorType']);
        $resInfo['statusShow'] = $this->statusShow($resInfo['status']);
        $resInfo['triggerShow'] = $this->triggerShow($resInfo['trigger']);

        return $this->returnMsg(0,$resInfo);
    }

    public function behaviorTypeShow($behaviorType)
    {
        $this->config->load('behavior');
        $behaviorTypeArr = $this->config->item('behaviorType');

        return isset($behaviorTypeArr[$behaviorType]) ? $behaviorTypeArr[$behaviorType]['name'] : '';
    }

    public function triggerShow($trigger)
    {
        $this->config->load('behavior');
        $triggerArr = $this->config->item('trigger');

        return isset($triggerArr[$trigger]['name']) ? $triggerArr[$trigger]['name'] : '';
    }

    public function editBehavior($id,$name,$behaviorType,$trigger,$normId,$jobType,$jobName,$desc)
    {
        $this->load->model('behaviorModel');
        $this->load->model('normModel');

        if(empty($id))
            return $this->returnMsg(101,'无效的行为ID');

        if(empty($name))
            return $this->returnMsg(102,'无效的行为名称');

        if(!$this->behaviorModel->editNameUnique($id,$name))
            return $this->returnMsg(103,'该名称已被占用');

        if(!$this->confirmBehaviorType($behaviorType))
            return $this->returnMsg(104,'非法的行为类型');

        if(!$this->confirmTrigger($trigger))
            return $this->returnMsg(105,'无效的触发器');

        if($behaviorType == self::$BEHAVIOR_TYPE_CUSTOMIZE)
        {
            $resNorm = $this->normModel->getNormInfo($normId);
            if(!$resNorm)
                return $this->returnMsg(106,'无效的指标ID');
        }

        if(!$this->confirmJobType($jobType))
            return $this->returnMsg(107,'无效的任务类型');

        if(empty($jobName))
            return $this->returnMsg(108,'无效的任务名称');

        if(empty($desc))
            return $this->returnMsg(109,'无效的描述信息');

        $data = array(
            'name' => $name,
            'behaviorType' => $behaviorType,
            'trigger' => $trigger,
            'normId' => $normId,
            'jobType' => $jobType,
            'jobName' => $jobName,
            'desc' => $desc,
            'status' => 0,
            'updTime' => time(),
        );

        $resUpd = $this->behaviorModel->updBehavior($id,$data);

        if(!$resUpd)
            return $this->returnMsg(107,'更新失败');

        return $this->returnMsg(0);
    }

    public function del($id)
    {
        if(empty($id))
            return $this->returnMsg(101,'无效的行为ID');

        $this->load->model('behaviorModel');

        $resDel = $this->behaviorModel->delBehaviorTrans($id);
        if(!$resDel)
            return $this->returnMsg(102,'删除失败');

        return $this->returnMsg(0);
    }

    public function enableBehavior($id)
    {
        if(empty($id))
            return $this->returnMsg(101,'无效的行为ID');

        $this->load->model('behaviorModel');
        $resEnable = $this->behaviorModel->enableBehavior($id);
        if(!$resEnable)
            return $this->returnMsg(102,'启动失败');

        return $this->returnMsg(0);
    }

    public function disabledBehavior($id)
    {
        if(empty($id))
            return $this->returnMsg(101,'无效的行为ID');

        $this->load->model('behaviorModel');
        $resDisabled = $this->behaviorModel->disabledBehavior($id);
        if(!$resDisabled)
            return $this->returnMsg(102,'禁用失败');

        return $this->returnMsg(0);
    }

}