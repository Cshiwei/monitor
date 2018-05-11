<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/8
 * Time: 11:15
 */

class Group extends CI_Controller{

    public function index()
    {
        $this->load->logic('effectLogic');

        $pageNum = $this->input->get('pageNum');
        $resList = $this->effectLogic->groupList($pageNum);

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

        $this->display('group');
    }

    public function add()
    {
        if($this->isAjax)
        {
            $this->load->logic('effectLogic');
            $name = $this->input->post('name');
            $desc = $this->input->post('desc');

            $resAdd = $this->effectLogic->addGroup($name,$desc);
            header("Content-type:application/json");
            echo json_encode($resAdd);
        }
        else
            $this->display('addgroup');
    }

    public function edit()
    {
        $this->load->logic('effectLogic');
        if($this->isAjax)
        {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $desc = $this->input->post('desc');

            $resUpd = $this->effectLogic->editGroup($id,$name,$desc);
            header("Content-type:application/json");
            echo json_encode($resUpd);
        }
        else
        {
            $groupId = $this->input->get('groupId');

            $resInfo = $this->effectLogic->groupInfo($groupId);
            if($resInfo['errNo']!=0)
                $this->fail('未获取到分组信息','/group');
            else
            {
                $info = $resInfo['result'];
                $this->assign('info',$info);
                $this->display('editgroup');
            }
        }
    }

    public function del()
    {
        $this->load->logic('effectLogic');
        $groupId = $this->input->post('groupId');

        $resDel = $this->effectLogic->delGroup($groupId);
        if($resDel['errNo']!=0)
            $this->fail($resDel['errMsg'],'/group');
        else
            $this->success('成功删除分组','/group');
    }
}