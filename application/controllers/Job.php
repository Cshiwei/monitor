<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 17:58
 */
class Job extends CI_Controller{

    private $param;

    public function run()
    {
        $this->load->logic('jobLogic');
        $jobName= $this->input->get('jobName');
        $param = json_decode($this->input->post('param'),true);
        $this->jobLogic->setParam($param,true);

        if(method_exists($this->jobLogic,$jobName))
        {
            $resLogId = $this->jobLogic->_taskBegin();
            $resJob =$this->jobLogic->$jobName();
            $this->jobLogic->_taskEnd($resLogId,$resJob);
        }
    }
}