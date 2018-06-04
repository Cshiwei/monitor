<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21
 * Time: 10:53
 */
class JobLogic extends CI_Logic{

    private $param;

    static $TASK_TYPE_EMAIL=1;

    public function setParam($param)
    {
        $this->param = $param;
    }

    public function run($jobId)
    {
        log_message('debug','开始执行任务，任务id为'.$jobId);
    }

    public function normBeyond()
    {
        $baseUrl = $this->config->item('base_url');

        $param = $this->param;
        $normId = $param['normId'];
        $normInfo = $param['normInfo'];

        $this->load->library('email');
        $this->email->from('caoshiwei@lightinthebox.com', 'caoshiwei');
        $this->email->to('caoshiwei@lightinthebox.com');
        $this->email->subject("指标[$normId]超出阈值请及时处理");
        $this->email->message("指标[$normId]超出阈值请及时处理,<a href='{$baseUrl}norm/normDetail?normId={$normId}'>{$normInfo['name']}</a>");
        $this->email->set_newline("\r\n");

        $this->email->send();
        $resSend = $this->email->print_debugger();
        return $this->returnMsg(0,$resSend);
    }

    public function email()
    {
        $this->load->model('behaviorModel');
        $behaviorId = $this->param['behaviorId'];
        $resTaskInfo = $this->behaviorModel->getTaskInfo($behaviorId,self::$TASK_TYPE_EMAIL);

        $emailTitle = $resTaskInfo['title'];
        $emailTo = $resTaskInfo['emailTo'];
        $emailContent = $resTaskInfo['content'];

        $emailToArr = explode(',',$emailTo);
        $this->load->library('email');
        $this->email->from('caoshiwei@lightinthebox.com', 'caoshiwei');
        $this->email->to($emailToArr);
        $this->email->subject($emailTitle);
        $this->email->message($emailContent);
        $this->email->set_newline("\r\n");

        $this->email->send();
        $resSend = $this->email->print_debugger();
        return $this->returnMsg(0,$resSend);
    }

    public function _taskBegin()
    {
        $this->load->model('behaviorModel');
        $behaviorId = $this->param['behaviorId'] ? $this->param['behaviorId'] : '';
        $now = time();
        $data = array(
            'jobId' => $this->param['jobId'],
            'behaviorId' => $behaviorId,
            'beginTime' => $now,
            'createTime' => $now,
            'updTime' => $now,
        );
        $resLogId = $this->behaviorModel->beginTaskLog($data);
        return $resLogId;
    }

    public function _taskEnd($logId,$res)
    {
        $this->load->model('behaviorModel');
        $now = time();
        $data = array(
            'errNo'   => $res['errNo'],
            'errMsg' => $res['errMsg'],
            'endTime' => $now,
            'updTime' => $now,
        );
        $this->behaviorModel->endTaskLog($logId,$data);
    }

    public function getJobInfo($jobId)
    {
        if(empty($jobId))
            return $this->returnMsg(101,'无效的jobID');

        $this->load->model('behaviorModel');
        $resJobInfo = $this->behaviorModel->getJobInfo($jobId);
        if(!$resJobInfo)
            return $this->returnMsg(102,'未获取到job信息');

        return $this->returnMsg(0,$resJobInfo);
    }
}