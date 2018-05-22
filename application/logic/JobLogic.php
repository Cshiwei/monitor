<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21
 * Time: 10:53
 */
class JobLogic extends CI_Logic{

    private $param;

    public function setParam($param)
    {
        $this->param = $param;
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

    public function reloadHost()
    {

    }

    public function failInsert()
    {

    }

    public function reload()
    {

    }

    public function _taskBegin()
    {
        $this->load->model('behaviorModel');
        $behaviorId = $this->param['behaviorId'];
        $now = time();
        $data = array(
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
}