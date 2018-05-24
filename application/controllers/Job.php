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
        log_message('debug','Job run is initialized');
        $this->load->logic('jobLogic');
        $jobName= $this->input->get('jobName');
        if(!$jobName)
            log_message('debug','未获取到jobName');

        $param = json_decode($this->input->post('param'),true);
        $this->jobLogic->setParam($param,true);
        log_message('debug','成功设置参数');
        if(method_exists($this->jobLogic,$jobName))
        {
            log_message('debug','任务存在开始执行');
            $resLogId = $this->jobLogic->_taskBegin();
            $resJob =$this->jobLogic->$jobName();
            $this->jobLogic->_taskEnd($resLogId,$resJob);
            log_message('debug','任务运行完毕');
        }
    }
}