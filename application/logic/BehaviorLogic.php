<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 18:23
 */
class BehaviorLogic extends CI_Logic{

   static $TASK_TYPE_EMAIL=1;


    public function addBehavior($name,$desc,$normId,$taskType,$taskParam)
    {
        $this->load->model('behaviorModel');
        $this->load->model('normModel');

        if(empty($name))
            return $this->returnMsg(101,'无效的行为名称');

        if(!$this->behaviorModel->addNameUnique($name))
            return $this->returnMsg(102,'该名称已被占用');

        if(empty($desc))
            return $this->returnMsg(108,'无效的描述');

        $resNorm = $this->normModel->getNormInfo($normId);
        if(!$resNorm)
            return $this->returnMsg(105,'无效的指标');

         $resConfirmTask = $this->confirmTask($taskType,$taskParam);
         if($resConfirmTask['errNo']!=0)
                return $resConfirmTask;

        $resAdd = $this->behaviorModel->addBehavior($name,$desc,$normId,$taskType,$taskParam);

        if(!$resAdd)
            return $this->returnMsg(106,'添加失败');

        return $this->returnMsg(0);
    }

    public function confirmTask($taskType,$taskParam)
    {
        $this->load->helper('email');
        switch($taskType)
        {
            case self::$TASK_TYPE_EMAIL :
                $emailTitle = isset($taskParam['emailTitle']) ? $taskParam['emailTitle'] : '';
                $emailTo = isset($taskParam['emailTo']) ? $taskParam['emailTo'] : '';
                $emailContent = isset($taskParam['emailContent']) ? $taskParam['emailContent'] : '';

                if(empty($emailTitle))
                    return $this->returnMsg(302,'无效的邮件标题');

                if(empty($emailTo))
                    return $this->returnMsg(303,'无效的收件人');

                $emailToArr = explode(',',$emailTo);
                if(!$this->batchCheckMail($emailToArr))
                    return $this->returnMsg(304,'收件人格式有误');

                if(empty($emailContent))
                    return $this->returnMsg(305,'无效的邮件内容');

                break;
            default :
                return $this->returnMsg(301,'无效的任务类型');
        }
    }

    public function batchCheckMail($emailArr)
    {
        if(empty($emailArr))
            return false;

        foreach ($emailArr as $key=>$val)
        {
            if(!filter_var($val, FILTER_VALIDATE_EMAIL))
                return false;
        }
        return true;
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
        $this->load->logic('normLogic');
        $this->load->model('normModel');
        if(empty($behaviorId))
            return $this->returnMsg(101,'无效的行为ID');

        $resInfo = $this->behaviorModel->getInfo($behaviorId);

        if(!$resInfo)
            return $this->returnMsg(102,'未获取到行为信息');

        $resTaskInfo = $this->behaviorModel->getTaskInfo($behaviorId,$resInfo['taskType']);
        $resNormInfo = $this->normModel->getNormInfo($resInfo['normId']);

        $normName = $resNormInfo ? $resNormInfo['name'] : '';
        $resInfo['norm'] = $normName;
        $thresholdShow = $this->normLogic->getThresholdShow($resNormInfo['relation'],$resNormInfo['threshold'],$resNormInfo['unit']);
        $resInfo['thresholdShow'] = $thresholdShow;
        $resInfo['taskInfo'] = $resTaskInfo;
        $resInfo['statusShow'] = $this->statusShow($resInfo['status']);

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

    public function editBehavior($id,$name,$desc,$normId,$taskType,$taskParam)
    {
        $this->load->model('behaviorModel');
        $this->load->model('normModel');

        if(empty($id))
            return $this->returnMsg(101,'无效的行为ID');

        $resBehaviorInfo = $this->behaviorModel->getInfo($id);
        if(!$resBehaviorInfo)
            return $this->returnMsg(102,'未获取到行为信息');

        if(empty($name))
            return $this->returnMsg(103,'无效的行为名称');

        if(!$this->behaviorModel->editNameUnique($id,$name))
            return $this->returnMsg(104,'该名称已被占用');

        if(empty($desc))
            return $this->returnMsg(105,'无效的描述');

        $resNorm = $this->normModel->getNormInfo($normId);
        if(!$resNorm)
            return $this->returnMsg(106,'无效的指标');

        $resConfirmTask = $this->confirmTask($taskType,$taskParam);
        if($resConfirmTask['errNo']!=0)
            return $resConfirmTask;

        $resUpd = $this->behaviorModel->updBehavior($id,$name,$desc,$normId,$taskType,$taskParam);

        if(!$resUpd)
            return $this->returnMsg(107,'更新失败');

        return $this->returnMsg(0);
    }

    public function del($id)
    {
        $this->load->model('behaviorModel');
        if(empty($id))
            return $this->returnMsg(101,'无效的行为ID');

        $resBehavior = $this->behaviorModel->getInfo($id);
        if(!$resBehavior)
            return $this->returnMsg(102,'未获取到行为ID');

        $this->load->model('behaviorModel');

        $resDel = $this->behaviorModel->delBehaviorTrans($id,$resBehavior['taskType']);

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