<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 18:23
 */
class BehaviorLogic extends CI_Logic{

    public function addBehavior($name,$type,$job,$desc)
    {
        $this->load->model('behaviorModel');

        if(empty($name))
            return $this->returnMsg(101,'无效的行为名称');

        if(!$this->behaviorModel->addNameUnique($name))
            return $this->returnMsg(102,'该名称已被占用');

        if(!$this->confirmType($type))
            return $this->returnMsg(103,'无效的行为类型');

        if(empty($job))
            return $this->returnMsg(104,'无效的方法/脚本名称');

        if(empty($desc))
            return $this->returnMsg(105,'描述信息不能为空');

        $now = time();
        $data = array(
            'name' => $name,
            'type' => $type,
            'jobName' => $job,
            'desc' => $desc,
            'createTime' => $now,
            'updTime' => $now,
        );
        $resAdd = $this->behaviorModel->addBehavior($data);

        if(!$resAdd)
            return $this->returnMsg(106,'添加失败');

        return $this->returnMsg(0);
    }

    /**csw
     * 验证type是否合法
     * @param $type
     * @return bool
     */
    public function confirmType($type)
    {
        $this->config->load('behavior');
        $typeArr = $this->config->item('type');

        return array_key_exists($type,$typeArr);
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
            $resList[$key]['jobNameShow'] = $this->jobShow($val['type'],$val['jobName']);
        }

        $res = array(
            'count' => $resCount,
            'list' => $resList,
            'pageShow' => $pageShow,
        );
        return $this->returnMsg(0,$res);
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
        if(empty($behaviorId))
            return $this->returnMsg(101,'无效的行为ID');

        $resInfo = $this->behaviorModel->getInfo($behaviorId);

        if(!$resInfo)
            return $this->returnMsg(102,'未获取到行为信息');

        $resInfo['jobNameShow'] = $this->jobShow($resInfo['type'],$resInfo['jobName']);

        return $this->returnMsg(0,$resInfo);
    }

    public function editBehavior($id,$name,$type,$job,$desc)
    {
        $this->load->model('behaviorModel');

        if(empty($id))
            return $this->returnMsg(101,'无效的行为ID');

        if(empty($name))
            return $this->returnMsg(102,'无效的行为名称');

        if(!$this->behaviorModel->editNameUnique($id,$name))
            return $this->returnMsg(103,'该名称已被占用');

        if(!$this->confirmType($type))
            return $this->returnMsg(104,'非法的行为类型');

        if(empty($job))
            return $this->returnMsg(105,'无效的方法/脚本');

        if(empty($desc))
            return $this->returnMsg(106,'描述不可为空');

        $data = array(
            'name' => $name,
            'type' => $type,
            'jobName' => $job,
            'desc' => $desc,
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
}