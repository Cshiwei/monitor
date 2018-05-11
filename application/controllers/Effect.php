<?php
/**
 * Created by PhpStorm.
 * User: csw
 * Date: 2018/5/7
 * Time: 17:49
 */
class Effect extends CI_Controller{

    public function index()
    {
        $this->load->logic('effectLogic');

        $pageNum = $this->input->get('pageNum');
        $name = $this->input->get('name');
        $norm = $this->input->get('norm');

        $resList = $this->effectLogic->effectList($pageNum,$name,$norm);

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

        $this->assign('name',$name);
        $this->assign('norm',$norm);
        $this->assign('pageShow',$pageShow);
        $this->assign('list',$list);

        $this->display('effect');
    }

    public function add()
    {
        $this->load->logic('effectLogic');
        if($this->isAjax)
        {
            $name = $this->input->post('name');
            $group = $this->input->post('group');
            $desc = $this->input->post('desc');

            $resAdd = $this->effectLogic->addEffect($name,$group,$desc);

            header('Content-type:application/json');
            echo json_encode($resAdd);
        }
        else
        {
            $groupList = $this->effectLogic->groupArr();

            $this->assign('groupList',$groupList);
            $this->display('addeffect');
        }
    }

    public function del()
    {
        $this->load->logic('effectLogic');

        $effectId = $this->input->post('effectId');

        $resDel = $this->effectLogic->delEffect($effectId);
        if($resDel['errNo']!=0)
            $this->fail($resDel['errMsg'],'/effect');
        else
            $this->success('成功删除影响','/effect');

    }

    public function edit()
    {
        $this->load->logic('effectLogic');
        if($this->isAjax)
        {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $group = $this->input->post('group');
            $desc = $this->input->post('desc');

            $resUpd = $this->effectLogic->editEffect($id,$name,$group,$desc);
            header('Content-type:application/json');
            echo json_encode($resUpd);
        }
        else
        {
            $effectId = $this->input->get('effectId');

            $groupList = $this->effectLogic->groupArr();
            $resInfo = $this->effectLogic->getEffectInfo($effectId);
            if($resInfo['errNo']!=0)
                $this->fail('未获取到该影响信息','/effect');
            else
            {
                $info = $resInfo['result'];

                $this->assign('groupList',$groupList);
                $this->assign('info',$info);
                $this->display('editEffect');
            }
        }
    }

    /**csw
     * 指定影响下已经绑定的指标
     */
    public function norm()
    {
        $effectId = $this->input->get('effectId');
        $this->load->logic('effectLogic');
        $resNorm = $this->effectLogic->getBindNorm($effectId);
        $resInfo = $this->effectLogic->getEffectInfo($effectId);

        $info = $resInfo['errNo']==0 ? $resInfo['result'] :array();
        $list = $resNorm['errNo']==0 ? $resNorm['result']['norm'] : array();

        $this->assign('info',$info);
        $this->assign('list',$list);
        $this->display('effectnorm');
    }

    /**csw
     * ajax获取所有指标
     */
    public function getAllNorm()
    {
        $this->load->logic('effectLogic');
        if($this->isAjax)
        {
            $resAllNorm = $this->effectLogic->getAllNorm();
            header('Content-type:application/json');
            echo json_encode($resAllNorm);
        }
    }

    /**csw
     * 影响添加新指标
     */
    public function addNorm()
    {
        $this->load->logic('effectLogic');
        $action = $this->input->post('action');
        if($action == 'doAdd')
        {
            $effectId = $this->input->post('effectId');
            $normCheck = $this->input->post('normCheck');
            $resAddNorm = $this->effectLogic->addNorm($effectId,$normCheck);
            if($resAddNorm['errNo']!=0)
                $this->fail($resAddNorm['errMsg'],"/effect/norm?effectId={$effectId}");
            else
                $this->success('添加成功',"/effect/norm?effectId={$effectId}");
        }
        else
        {
            $effectId = $this->input->get('effectId');
            $resNorm = $this->effectLogic->getNoBindNorm($effectId);
            $resInfo = $this->effectLogic->getEffectInfo($effectId);


            $info = $resInfo['errNo']==0 ? $resInfo['result'] : array();
            $list = $resNorm['errNo']==0 ? $resNorm['result'] : array();

            $this->assign('info',$info);
            $this->assign('list',$list);

            $this->display('effectaddnorm');
        }
    }

    /**csw
     * 删除指定影响下了指标
     */
    public function delNorm()
    {
        $this->load->logic('effectLogic');
        $effectId = $this->input->post('effectId');
        $normId = $this->input->post('normId');

        $resDel = $this->effectLogic->delNorm($effectId,$normId);
        header('Content-type:application/json');
        echo json_encode($resDel);
    }

    public function normRecent()
    {
        $this->load->logic('effectLogic');
        $normId = $this->input->post('normId');

        $resNormRecent = $this->effectLogic->normRecent($normId);
        header('Content-type:application/json;');
        echo json_encode($resNormRecent);
    }

}