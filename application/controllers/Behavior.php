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
        $this->load->logic('normLogic');
        if($this->isAjax)
        {
            $action = $this->input->post('action');
            switch($action)
            {
                default :
                    $name = $this->input->post('name');
                    $desc = $this->input->post('desc');
                    $normId = $this->input->post('normId');
                    $taskType = $this->input->post('taskType');
                    $taskParam = $this->input->post('taskParam');

                    $res = $this->behaviorLogic->addBehavior($name,$desc,$normId,$taskType,$taskParam);
            }
            header('Content-type:application/json');
            echo json_encode($res);
        }
        else
        {
            $this->config->load('behavior');
            $taskType = $this->config->item('taskType');
            $resAllNorm = $this->normLogic->getAllNorm();
            $allNorm = $resAllNorm['errNo']==0 ? $resAllNorm['result'] : array();

            $this->assign('taskType',$taskType);
            $this->assign('allNorm',$allNorm);
            $this->display('addbehavior');
        }
    }

    public function edit()
    {
        $this->load->logic('behaviorLogic');
        $this->load->logic('normLogic');
        if($this->isAjax)
        {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $desc = $this->input->post('desc');
            $normId = $this->input->post('normId');
            $taskType = $this->input->post('taskType');
            $taskParam = $this->input->post('taskParam');


            $resUpd = $this->behaviorLogic->editBehavior($id,$name,$desc,$normId,$taskType,$taskParam);
            header('Content-type:application/json');
            echo json_encode($resUpd);
        }
        else
        {
            $behaviorId = $this->input->get('id');

            $this->config->load('behavior');
            $taskType = $this->config->item('taskType');

            $resAllNorm = $this->normLogic->getAllNorm();
            $allNorm = $resAllNorm['errNo']==0 ? $resAllNorm['result'] : array();

            $resInfo = $this->behaviorLogic->getInfo($behaviorId);
            if($resInfo['errNo']!=0)
                $this->fail($resInfo['errMsg'],'/behavior');
            else
            {
                $info = $resInfo['result'];

                $this->assign('taskType',$taskType);
                $this->assign('allNorm',$allNorm);
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

    public function enableBehavior()
    {
        $id = $this->input->post("id");
        $this->load->logic('behaviorLogic');
        $resEnable = $this->behaviorLogic->enableBehavior($id);
        header("Content-type:application/json;");
        echo json_encode($resEnable);
    }

    public function disabledBehavior()
    {
        $id = $this->input->post("id");
        $this->load->logic('behaviorLogic');
        $resDisabled = $this->behaviorLogic->disabledBehavior($id);
        header("Content-type:application/json;");
        echo json_encode($resDisabled);
    }

}