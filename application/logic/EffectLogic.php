<?php
/**
 * Created by PhpStorm.
 * User: csw
 * Date: 2018/5/7
 * Time: 18:21
 */

class EffectLogic extends CI_Logic{

    public function addEffect($name,$group,$desc)
    {
        if(empty($name))
            return $this->returnMsg(101,'无效的名称');

        if(empty($group))
            return $this->returnMsg(102,'无效的分组');

        if(empty($desc))
            return $this->returnMsg(103,'无效的描述');

        $this->load->model('effectModel');
        if(!$this->effectModel->effectNameUnique($name))
            return $this->returnMsg(105,'该名称已被占用');

        $now = time();
        $data = array(
            'name' => $name,
            'groupId' => $group,
            'desc' => $desc,
            'createTime' => $now,
            'updTime' => $now,
        );
        $resAdd = $this->effectModel->addEffect($data);
        if(!$resAdd)
            return $this->returnMsg(104,'添加失败');

        return $this->returnMsg(0);
    }


    public function effectList($pageNum,$name,$norm)
    {
        $this->load->model('effectModel');

        $pageNum = intval($pageNum) <= 0 ? 1 : $pageNum;
        $perPage = 10;
        $offset = $this->getOffset($pageNum,$perPage);

        $where = array();
        empty($name) or $where['name'] = $name;
        empty($norm) or $where['norm'] = $norm;

        $resCount = $this->effectModel->effectCount($where);
        $resList = $this->effectModel->getList($where,$offset,$perPage);
        $groupArr = $this->groupArr();

        $pageShow = $this->getPageShow("/effect?name={$name}&norm={$norm}",$resCount,$pageNum,$perPage);

        if(!$resList)
            return $this->returnMsg(101,'未获取到列表信息');

        foreach ($resList as $key=>$val)
        {
            $resList[$key]['groupShow'] = isset($groupArr[$val['groupId']]) ? $groupArr[$val['groupId']]['name'] : '';
        }

        $res = array(
            'count' => $resCount,
            'list' => $resList,
            'pageShow' => $pageShow,
        );
        return $this->returnMsg(0,$res);
    }

    public function delEffect($effectId)
    {
        if(empty($effectId))
            return $this->returnMsg(101,'无效的影响ID');

        $this->load->model('effectModel');

        $resDel = $this->effectModel->delEffectTrans($effectId);
        if(!$resDel)
            return $this->returnMsg(102,'删除失败');

        return $this->returnMsg(0);
    }

    public function groupList($pageNum=1)
    {
        $this->load->model('effectModel');

        $pageNum = intval($pageNum) <= 0 ? 1 : $pageNum;
        $perPage = 10;
        $offset = $this->getOffset($pageNum,$perPage);

        $where = array();

        $resCount = $this->effectModel->groupCount($where);
        $resList = $this->effectModel->groupList($where,$offset,$perPage);
        $pageShow = $this->getPageShow('/group',$resCount,$pageNum,$perPage);

        if(!$resList)
            return $this->returnMsg(101,'未获取到列表信息');


        $res = array(
            'count' => $resCount,
            'list' => $resList,
            'pageShow' => $pageShow,
        );
        return $this->returnMsg(0,$res);
    }


    public function addGroup($name,$desc)
    {
        if(empty($name))
            return $this->returnMsg(101,'无效的分组名称');

        if(empty($desc))
            return $this->returnMsg(102,'无效的描述信息');

        $this->load->model('effectModel');

        if(!$this->effectModel->nameUnique($name))
            return $this->returnMsg(103,'该分组名称已被占用');

        $data = array(
            'name'  => $name,
            'desc' => $desc,
        );
        $resAdd = $this->effectModel->addGroup($data);

        if(!$resAdd)
            return $this->returnMsg(104,'添加失败');

        return $this->returnMsg(0);
    }

    public function groupInfo($groupId)
    {
        if(empty($groupId))
            return $this->returnMsg(101,'无效的分组ID');

        $this->load->model('effectModel');
        $resInfo = $this->effectModel->groupInfo($groupId);

        if(!$resInfo)
            return $this->returnMsg(102,'未获取到分组信息');

        return $this->returnMsg(0,$resInfo);
    }

    public function editGroup($id,$name,$desc)
    {
        if(empty($id))
            return $this->returnMsg(101,'无效的分组ID');

        if(empty($name))
            return $this->returnMsg(102,'无效的分组名称');

        if(empty($desc))
            return $this->returnMsg(103,'无效的分组描述');

        $this->load->model('effectModel');

        if(!$this->effectModel->nameEditUnique($id,$name))
            return $this->returnMsg(104,'该分组名称已被占用');

        $data = array(
            'name' => $name,
            'desc' => $desc,
            'updTime' => time(),
        );

        $resUpd = $this->effectModel->updGroup($id,$data);
        if(!$resUpd)
            return $this->returnMsg(105,'信息更新失败');

        return $this->returnMsg(0);
    }

    public function delGroup($id)
    {
        $this->load->model('effectModel');
        if(empty($id))
            return $this->returnMsg(101,'无效的分组ID');

        if($this->effectModel->getEffectByGroup($id))
            return $this->returnMsg(102,'该分组下仍然存在影响，无法删除');

        $resDel = $this->effectModel->delGroup($id);
        if(!$resDel)
            return $this->returnMsg(102,'删除分组失败');

        return $this->returnMsg(0);
    }

    public function groupArr()
    {
        $this->load->helper('array');
        $this->load->model('effectModel');
        $resList = $this->effectModel->groupList(array(),'','');
        $resList = array_val_key($resList,'id');
        return $resList;
    }


    public function getEffectInfo($effectId)
    {
        if(empty($effectId))
            return $this->returnMsg(101,'无效的影响ID');

        $this->load->model('effectModel');

        $resInfo = $this->effectModel->effectInfo($effectId);
        if(!$resInfo)
            return $this->returnMsg(102,'未获取到该影响详细信息');

        return $this->returnMsg(0,$resInfo);
    }

    public function editEffect($id,$name,$group,$desc)
    {
        if(empty($id))
            return $this->returnMsg(101,'无效的影响ID');

        if(empty($name))
            return $this->returnMsg(102,'无效的名称');

        if(empty($group))
            return $this->returnMsg(103,'无效的分组');

        if(empty($desc))
            return $this->returnMsg(104,'无效的描述');

        $this->load->model('effectModel');
        if(!$this->effectModel->editEffectNameUnique($id,$name))
            return $this->returnMsg(105,'该名称已被占用');

        $data = array(
            'name' => $name,
            'desc' => $desc,
            'groupId' => $group,
            'updTime' => time(),
        );

        $resUpd = $this->effectModel->updEffect($id,$data);
        if(!$resUpd)
            return $this->returnMsg(106,'更新失败');

        return $this->returnMsg(0);
    }

    /**csw
     * 获取所有指标
     * @return array
     */
    public function getAllNorm()
    {
        $this->load->model('normModel');
        $resAllNorm = $this->normModel->getList(array(),'','');
        if(!$resAllNorm)
            return $this->returnMsg(101,'未获取到指标信息');

        return $this->returnMsg(0,$resAllNorm);
    }

    /**csw
     * 获取未经绑定的指标
     */
    public function getNoBindNorm($effectId)
    {
        $this->load->model('effectModel');
        $resNorm = $this->effectModel->getNoBindNorm($effectId);

        if(!$resNorm)
            return $this->returnMsg(101,'未获取到指标信息');

        return $this->returnMsg(0,$resNorm);
    }

    /**csw
     * 获取已经绑定指定影响的指标
     */
    public function getBindNorm($effectId)
    {
        $this->load->helper('number');
        $this->load->model('effectModel');
        $this->load->logic('normLogic');
        $this->load->helper('array');

        $resNorm = $this->effectModel->getBindNorm($effectId);

        if(!$resNorm)
            return $this->returnMsg(102,'未获取到指标信息');

        $norms = array_column($resNorm,'id');

        $resNormCensus = $this->normLogic->getRecentCensus($norms);
        $normCensus = $resNormCensus['errNo']==0 ? $resNormCensus['result'] : array();

        $unitArr = $this->normLogic->getUnitArr();
        foreach ($resNorm as $key=>$val)
        {
            $unitShow = isset($unitArr[$val['unit']]) ? $unitArr[$val['unit']]['name'] : '';
            $panelType = 'success';
            $recentVal = '';
            $recentValShow = '';
            if(isset($normCensus[$val['id']]))
            {
                $recentVal = $normCensus[$val['id']]['value'];
                $recentValShow = $recentVal.' '.$unitShow;
                if(data_compare($recentVal,$val['relation'],$val['threshold']))
                    $panelType = 'danger';
            }
            $resNorm[$key]['panelType'] = $panelType;
            $resNorm[$key]['recentValShow'] = $recentValShow;
        }

        $res = array(
            'norm' => $resNorm,
        );

        return $this->returnMsg(0,$res);
    }

    /**csw
     * 影响添加指标
     */
    public function addNorm($effectId,$normCheck)
    {
        $this->load->model('effectModel');
        $this->load->model('normModel');

        if(empty($effectId))
            return $this->returnMsg(101,'无效的影响ID');

        if(empty($normCheck))
            return $this->returnMsg(102,'无效的指标集合');

        $resEffect = $this->effectModel->effectInfo($effectId);
        if(!$resEffect)
            return $this->returnMsg(103,'无法获取到影响信息');

        $norms = array_unique($normCheck);
        $resNorms = $this->normModel->getNormsInfo($normCheck);
        if(!$resNorms || (count($resNorms)) != count($norms))
            return $this->returnMsg(104,'指标信息已过期，请重新添加');

        $resAdd = $this->effectModel->addNorms($effectId,$norms);
        if(!$resAdd)
            return $this->returnMsg(105,'添加指标失败');

        return $this->returnMsg(0);
    }

    /**csw
     * 删除某个影响下的指标
     */
    public function delNorm($effectId,$normId)
    {
        if(empty($effectId))
            return $this->returnMsg(101,'无效的影响ID');

        if(empty($normId))
            return $this->returnMsg(102,'无效的指标ID');

        $this->load->model('effectModel');
        $resDel = $this->effectModel->delNorm($effectId,$normId);
        if(!$resDel)
            return $this->returnMsg(103,'删除失败');

        return $this->returnMsg(0);
    }

    /**csw
     * 获取最近的指标数据
     */
    public function normRecent($normId)
    {
        $this->load->model('effectModel');
        $this->load->logic('normLogic');
        $this->load->model('normModel');


        if(empty($normId))
            return $this->returnMsg(101,'无效的指标ID');

        $resNorm = $this->normModel->getNormInfo($normId);
        if(!$resNorm)
            return $this->returnMsg(102,'未获取到指标信息');

        $resNorm['thresholdShow'] = $this->normLogic->getThresholdShow($resNorm['relation'],$resNorm['threshold'],$resNorm['unit']);

        $num = 50;
        $resRencent = $this->normLogic->recentCensus($normId,$num);
        $list = $resRencent['errNo']==0 ? $resRencent['result'] : array();

        $smarty = $this->mysmarty->getSmarty();
        $smarty->assign('info',$resNorm);
        $smarty->assign('list',$list);
        $html = $smarty->fetch('normmodel.tpl');

        $res = array(
            'html' => $html,
        );

        return $this->returnMsg(0,$res);
    }

    public function getALLEffect()
    {
        $this->load->model('effectModel');
        $res = $this->effectModel->getAllEffect();
        if(!$res)
            return $this->returnMsg(101,'未获取到影响信息');

        return $this->returnMsg(0,$res);
    }


}
