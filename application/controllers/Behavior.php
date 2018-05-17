<?php
/**
 * Created by PhpStorm.
 * User: csw
 * Date: 2018/5/9
 * Time: 17:02
 */
class Behavior extends CI_Controller{

    public function index()
    {
        $this->load->logic('behaviorLogic');

        $pageNum = $this->input->get('pageNum');
        $resList = $this->behaviorLogic->behaviorList($pageNum);

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

        $this->assign('list',$list);
        $this->assign('pageShow',$pageShow);

        $this->display('behavior');
    }


    public function add()
    {
        $this->load->logic('behaviorLogic');
        if($this->isAjax)
        {
            $name = $this->input->post('name');
            $type = $this->input->post('type');
            $job = $this->input->post('jobName');
            $desc = $this->input->post('desc');

            $resAdd = $this->behaviorLogic->addBehavior($name,$type,$job,$desc);
            header('Content-type:application/json');
            echo json_encode($resAdd);
        }
        else
        {
            $this->config->load('behavior');
            $typeArr = $this->config->item('type');
            $triggerType = $this->config->item('triggerType');
            $trigger = $this->config->item('trigger');

            $this->assign('trigger',$trigger);
            $this->assign('triggerType',$triggerType);
            $this->assign('typeArr',$typeArr);
            $this->display('addbehavior');
        }
    }

    public function edit()
    {
        $this->load->logic('behaviorLogic');
        if($this->isAjax)
        {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $type = $this->input->post('type');
            $job = $this->input->post('jobName');
            $desc = $this->input->post('desc');

            $resUpd = $this->behaviorLogic->editBehavior($id,$name,$type,$job,$desc);
            header('Content-type:application/json');
            echo json_encode($resUpd);
        }
        else
        {
            $behaviorId = $this->input->get('id');

            $this->config->load('behavior');
            $typeArr = $this->config->item('type');

            $resInfo = $this->behaviorLogic->getInfo($behaviorId);
            if($resInfo['errNo']!=0)
                $this->fail($resInfo['errMsg'],'/behavior');
            else
            {
                $info = $resInfo['result'];

                $this->assign('typeArr',$typeArr);
                $this->assign('info',$info);

                $this->display('editbehavior');
            }
        }

    }

    public function detail()
    {
        $this->load->logic('behaviorLogic');
        $id = $this->input->get('id');

        $resInfo = $this->behaviorLogic->getInfo($id);

        if($resInfo['errNo']!=0)
            $this->fail($resInfo['errMsg'],'/behavior');
        else
        {
            $info = $resInfo['result'];

            $this->assign('info',$info);
            $this->display('behaviordetail');
        }
    }

    public function del()
    {
        $this->load->logic('behaviorLogic');
        $behaviorId = $this->input->post('id');

        $resDel = $this->behaviorLogic->del($behaviorId);

        if($resDel['errNo']!=0)
            $this->fail($resDel['errMsg'],'/behavior');
        else
            $this->success($resDel['errMsg'],'/behavior');
    }

}