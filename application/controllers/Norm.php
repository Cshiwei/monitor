<?php
/**
 * Created by PhpStorm.
 * User: csw
 * Date: 2018/5/3
 * Time: 15:21
 * 指标页面控制器
 */
class Norm extends CI_Controller{

    public function index()
    {
        $this->load->logic('normLogic');

        $pageNum = $this->input->get('pageNum');

        $resList = $this->normLogic->normList($pageNum);

        if($resList['errNo']==0)
        {
            $list = $resList['result']['list'];
            $pageShow = $resList['result']['pageShow'];
        }
        else
        {
            $list = array();
            $pageShow = '';
        }

        $this->assign('pageShow',$pageShow);
        $this->assign('list',$list);

        $this->display('norm');
    }

    /**添加指标
     */
    public function addNorm()
    {
        $this->load->logic('normLogic');
        if($this->isAjax)
        {
            $normName = $this->input->post('normName');
            $normDesc = $this->input->post('normDesc');
            $normRelation = $this->input->post('normRelation');
            $normThreshold = $this->input->post('normThreshold');
            $normUnit = $this->input->post('normUnit');

            $resAdd = $this->normLogic->addNorm($normName,$normDesc,$normRelation,$normThreshold,$normUnit);

            header("Content-Type:applycation/json");
            echo json_encode($resAdd);
        }
        else
        {
            $relationArr = $this->normLogic->getRelationArr();
            $unitArr = $this->normLogic->getUnitArr();

            $this->assign('relationArr',$relationArr);
            $this->assign('unitArr',$unitArr);

            $this->display('addnorm');
        }
    }

    /**csw
     *删除指标
     */
    public function delNorm()
    {
        $this->load->logic('normLogic');
        $normId = $this->input->post('normId');

        $resDel = $this->normLogic->delNorm($normId);

        if($resDel['errNo']!=0)
            $this->fail($resDel['errMsg'],'/norm');
        else
            $this->success('成功删除指标','/norm');
    }

    /**csw
     * 编辑指标
     */
    public function editNorm()
    {
        $this->load->logic('normLogic');
        if ($this->isAjax)
        {
            $normId = $this->input->post('normId');
            $normName = $this->input->post('normName');
            $normDesc = $this->input->post('normDesc');
            $normRelation = $this->input->post('normRelation');
            $normThreshold = $this->input->post('normThreshold');
            $normUnit = $this->input->post('normUnit');

            $resAdd = $this->normLogic->editNorm($normId,$normName,$normDesc,$normRelation,$normThreshold,$normUnit);

            header("Content-Type:applycation/json");
            echo json_encode($resAdd);
        }
        else
        {
            $normId = $this->input->get('normId');

            $resInfo = $this->normLogic->getNormInfo($normId);
            if($resInfo['errNo']==0)
            {
                $relationArr = $this->normLogic->getRelationArr();
                $unitArr = $this->normLogic->getUnitArr();

                $this->assign('relationArr',$relationArr);
                $this->assign('unitArr',$unitArr);
                $this->assign('info',$resInfo['result']);

                $this->display('editNorm');
            }
            else
                $this->fail($resInfo['errMsg'],'/norm');
        }
    }


    /**csw
     * 指标统计信息展示
     */
    public function normDetail()
    {
        $this->load->logic('normLogic');
        $normId = $this->input->get('normId');

        $pageNum = $this->input->get('pageNum');
        $day = $this->input->get('day');

        $resDetail = $this->normLogic->normDetail($normId,$pageNum,$day);

        if($resDetail['errNo']==0)
        {
            $list = $resDetail['result']['list'];
            $pageShow = $resDetail['result']['pageShow'];
            $info = $resDetail['result']['info'];
            $linChart = $resDetail['result']['lineChart'];
        }
        else
        {
            $list = array();
            $pageShow = '';
            $info = array();
            $linChart = array();
        }


        $this->assign('lineChart',$linChart);
        $this->assign('info',$info);
        $this->assign('list',$list);
        $this->assign('pageShow',$pageShow);
        $this->assign('day',$day);
        $this->display('normdetail');
    }

    /**csw
     * norm折线图
     */
    public function lineChart()
    {
        $this->load->logic('normLogic');

        $today = date('Y-m-d',time());
        $todayStamp = strtotime($today);

        $normId = $this->input->get('normId');
        $beginDay = $this->input->post('beginDay');
        $endDay = $this->input->post('endDay');

        if(empty($beginDay))
            $beginDay = date("Y-m-d",strtotime('-1 day',$todayStamp));

        if(empty($endDay))
            $endDay = $today;

        $resLine = $this->normLogic->line($normId,$beginDay,$endDay);

        if($resLine['errNo']!=0)
            $this->fail($resLine['errMsg'],"/norm");
        else
        {
            $info = $resLine['result']['info'];
            $lineStr = json_encode($resLine['result']['lineArr']);
            $legend = json_encode($resLine['result']['legend']);

            $this->assign('info',$info);
            $this->assign('legend',$legend);
            $this->assign('lineStr',$lineStr);
            $this->assign('beginDay',$beginDay);
            $this->assign('endDay',$endDay);
            $this->display('normLine');
        }

    }

    /**csw
     * 指标关联行为
     */
    public function joinBehavior()
    {
        $this->load->logic('normLogic');

        $normId = $this->input->get('normId');
        $resBehavior = $this->normLogic->getBehavior($normId);

        $this->display('normbehavior');
    }
}