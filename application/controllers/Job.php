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
        $jobId = $this->input->get('jobId');
        $resJob = $this->jobLogic->run($jobId);
        if($resJob['errNo']!=0)
            log_message('error',$resJob['errMsg']);

        header('Content-type:application/json');
        echo json_encode($resJob);
    }

}