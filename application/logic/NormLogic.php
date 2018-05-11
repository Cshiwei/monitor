<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/4
 * Time: 14:39
 */
class NormLogic extends CI_Logic{

    public function normList($pageNum=1)
    {
        $this->load->helper('array');
        $this->load->helper('number');
        $this->config->load('norm');
        $this->load->model('normModel');

        $pageNum = intval($pageNum) <= 0 ? 1 : $pageNum;
        $perPage = 10;
        $offset = $this->getOffset($pageNum,$perPage);

        $where = array();

        $resCount = $this->normModel->normCount($where);
        $resList = $this->normModel->getList($where,$offset,$perPage);
        $norms = array_column($resList,'id');
        $resNormsInfo = $this->normModel->getRecentCensus($norms);
        $normsInfo = array_val_key($resNormsInfo,'normId');

        $pageShow = $this->getPageShow('/norm',$resCount,$pageNum,$perPage);

        if(!$resList)
            return $this->returnMsg(101,'未获取到列表信息');


        foreach ($resList as $key=>$val)
        {
            if(isset($normsInfo[$val['id']]))
                $resList[$key]['scene'] = data_compare($normsInfo[$val['id']]['value'],$val['relation'],$val['threshold']) ? 'danger' : 'default';
            else
                $resList[$key]['scene'] = 'default';

            $resList[$key]['thresholdShow'] = $this->getThresholdShow($val['relation'],$val['threshold'],$val['unit']);
        }

        $res = array(
            'count' => $resCount,
            'list' => $resList,
            'pageShow' => $pageShow,
        );
        return $this->returnMsg(0,$res);
    }

    /**添加指标
     * @param $normName
     * @param $normDesc
     * @param $normRelation
     * @param $normThreshold
     * @param $normUnit
     * @return array
     */
    public function addNorm($normName,$normDesc,$normRelation,$normThreshold,$normUnit)
    {
        $this->load->model('normModel');
        if(empty($normName))
            return $this->returnMsg(101,'无效的指标名称');

        if(empty($normDesc))
            return $this->returnMsg(102,'无效的指标描述');

        if(empty($normRelation))
            return $this->returnMsg(103,'无效的阈值关系');

        $normThreshold = intval($normThreshold);

        if(empty($normUnit))
            return $this->returnMsg(105,'无效的阈值单位');

        if(!$this->normModel->addNameUnique($normName))
            return $this->returnMsg(107,'该名称已被占用');

        $now = time();
        $addData = array(
            'name'  => $normName,
            'desc'  => $normDesc,
            'relation'  => $normRelation,
            'threshold' => $normThreshold,
            'unit'  => $normUnit,
            'createTime' => $now,
            'updTime' => $now,
        );

        $resAdd = $this->normModel->addNorm($addData);

        if(!$resAdd)
            return $this->returnMsg(106,'添加失败');

        return $this->returnMsg(0);
    }

    /**csw
     * 获取relation数组
     */
    public function getRelationArr()
    {
        $this->config->load('norm');
        $relationArr = $this->config->item('relation');
        return $relationArr;
    }

    /**csw
     * 获取单位数组
     */
    public function getUnitArr()
    {
        $this->config->load('norm');
        $unitArr = $this->config->item('unit');
        return $unitArr;
    }

    /**csw
     * 删除指标
     */
    public function delNorm($normId)
    {
        $this->load->model('normModel');
        if(empty($normId))
            return $this->returnMsg(101,'无效的指标ID');

        $resDel = $this->normModel->delNormTrans($normId);

        if(!$resDel)
            return $this->returnMsg(102,'删除指标失败');

        return $this->returnMsg(0,'删除成功');
    }

    /**csw
     * 获取指标详情
     */
    public function getNormInfo($normId)
    {
        if(empty($normId))
            return $this->returnMsg(101,'无效的指标ID');

        $this->load->model('normModel');
        $resInfo = $this->normModel->getNormInfo($normId);

        if($resInfo)
        {
            return $this->returnMsg(0,$resInfo);
        }

        return $this->returnMsg(102,'未获取到指标信息');
    }

    /**csw
     * 更新指标信息
     */
    public function editNorm($normId,$normName,$normDesc,$normRelation,$normThreshold,$normUnit)
    {
        $this->load->model('normModel');
        if(empty($normId))
            return $this->returnMsg(106,'无效的指标Id');

        if(empty($normName))
            return $this->returnMsg(102,'无效的指标名称');

        if(empty($normDesc))
            return $this->returnMsg(103,'无效的指标描述');

        if(empty($normRelation))
            return $this->returnMsg(104,'无效的阈值关系');

        $normThreshold = intval($normThreshold);

        if(empty($normUnit))
            return $this->returnMsg(106,'无效的阈值单位');

        if(!$this->normModel->editNameUnique($normId,$normName))
            return $this->returnMsg(108,'该名称已被占用');

        $data = array(
            'name' => $normName,
            'desc' => $normDesc,
            'relation' => $normRelation,
            'threshold' => $normThreshold,
            'unit' => $normUnit,
            'updTime' => time(),
        );

        $condition = array('id'=>$normId);
        $resEdit = $this->normModel->editNorm($data,$condition);

        if(!$resEdit)
            return $this->returnMsg(107,'更新失败');

        return $this->returnMsg(0);
    }

    /**csw
     * 获取norm最近一次的记录值
     */
    public function getRecentCensus($norms)
    {
        if(empty($norms))
            return $this->returnMsg(101,'无效的指标id');
        $this->load->helper('array');
        $this->load->model('normModel');
        $resNorms = array();
        $resNorms = $this->normModel->getRecentCensus($norms);
        if(!$resNorms)
            return $this->returnMsg(102,'未获取到指标统计信息');

        $resNorms = array_val_key($resNorms,'normId');
        return $this->returnMsg(0,$resNorms);
    }

    /**csw
     * 插入norm统计数据
     */
    public function addNormCensus($normId,$normValue,$normTime)
    {
        $this->load->model('normModel');
        if(empty($normId))
            return $this->returnMsg(101,'无效的指标ID');

        if(empty($normTime))
            return $this->returnMsg(102,'无效的指标生成时间');

        $resNormInfo = $this->normModel->getNormInfo($normId);
        if(!$resNormInfo)
            return $this->returnMsg(103,'不存在该指标信息');

        $data = array(
            'normId' => $normId,
            'value' => $normValue,
            'normTime' => $normTime,
            'createTime' => time(),
        );
        $resAdd= $this->normModel->addNormCensus($data);
        if(!$resAdd)
            return $this->returnMsg(104,'添加失败');

        return $this->returnMsg(0);
    }

    private function addTestData()
    {
        $this->load->model('normModel');
        $a = array(1,2,3);
        for ($i=1;$i<=100;$i++)
        {   $key = array_rand($a,1);
            $normId = $a[$key];
            $value = rand(1,1000);
            $normTime = rand(1525104000,1525924718);
            /*$data = array(
                'normId' => $normId,
                'value' => $value,
                'normTime' => $normTime,
                'createTime' => time(),
            );*/
            $this->addNormCensus($normId,$value,$normTime);
            //$this->normModel->addNormCensus($data);
        }
    }

    public function getThresholdShow($relation,$threshold,$unit)
    {
        $relationArr = $this->getRelationArr();
        $unitArr =$this->getUnitArr();

        $symbol = isset($relationArr[$relation]['symbol']) ? $relationArr[$relation]['symbol'] : '';
        $unitShow = isset($unitArr[$unit]['name']) ? $unitArr[$unit]['name'] : '';
        return  $symbol.' '.$threshold.' '.$unitShow;
    }

    public function recentCensus($normId,$number)
    {
        if(empty($normId))
            return $this->returnMsg(101,'无效的指标ID');

        if(empty($number))
            return $this->returnMsg(102,'请指定条数');

        $this->load->helper('number');
        $this->load->model('normModel');
        $recent = $this->normModel->recentCensus($normId,$number);

        if(!$recent)
            return $this->returnMsg(103,'未获取到数据');

        foreach ($recent as $key=>$val)
        {
            $recent[$key]['scene'] = data_compare($val['censusValue'],$val['relation'],$val['threshold'])===true ? 'danger' : 'default';
            $recent[$key]['normTimeShow'] = date('Y-m-d H:i:s',$val['censusTime']);
            $recent[$key]['thresholdShow'] = $this->getThresholdShow('',$val['censusValue'],$val['unit']);
        }

        return $this->returnMsg(0,$recent);
    }

    /**csw
     * 指标详细信息
     * 包括数据统计信息
     */
    public function normDetail($normId,$pageNum,$day)
    {
        $this->load->model('normModel');
        $this->load->helper('number');
        $resNorm = $this->normModel->getNormInfo($normId);
        if(!$resNorm)
            return $this->returnMsg(101,'未获取到指标信息');

        $pageNum = intval($pageNum) <= 0 ? 1 : $pageNum;
        $perPage = 8;
        $offset = $this->getOffset($pageNum,$perPage);

        $where = array();
        empty($day) or $where['day'] = $day;
        $where['normId'] = $normId;

        $normCensusCount = $this->normModel->normCensusCount($where);
        $resNormCensus = $this->normModel->normCensus($where,$offset,$perPage);

        if($resNormCensus)
        {
            $pageShow = $this->getPageShow("/norm/normDetail?normId={$normId}&day={$day}",$normCensusCount,$pageNum,$perPage);

            $x = array();
            foreach ($resNormCensus as $key=>$val)
            {
                $x[] = $key + 1;
                $y[] = $val['value'];
                $resNormCensus[$key]['valueShow'] = $this->getThresholdShow('',$val['value'],$resNorm['unit']);
                $resNormCensus[$key]['normTimeShow'] = date('Y-m-d H:i:s',$val['normTime']);
                $resNormCensus[$key]['scene'] = data_compare($val['value'],$resNorm['relation'],$resNorm['threshold']) ? 'danger' : 'default';
            }

            $xStr = implode(',',$x);
            $yStr = implode(',',$y);
            $lineChart = array('x'=>$xStr,'y'=>$yStr);

            $res = array(
                'list' => $resNormCensus,
                'pageShow' => $pageShow,
                'info' => $resNorm,
                'lineChart' => $lineChart,
            );

        }
        else
        {
            $res = array(
                'list' => array(),
                'pageShow' => '',
                'info' => $resNorm,
                'lineChart' => array(),
            );
        }
        return $this->returnMsg(0,$res);
    }
}