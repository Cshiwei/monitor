<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/16
 * Time: 18:56
 */

class RegisterLogic extends CI_Logic{

    //注册行为
    public $triggerArr = array();

    public $param = array();

    public $sockPool = array();

    public $out=array();

    static $TASK_TYPE_EMAIL = 1;

    //接口相关trigger
    static $TRIGGER_DATA_RECEIVE_REQUEST =1;
    static $TRIGGER_DATA_SUCCESS_INSERT = 2;
    static $TRIGGER_DATA_FAIL_INSERT = 3;

    //指标相关trigger
    static $TRIGGER_NORM_NORMAL = 4;
    static $TRIGGER_NORM_BEYOND = 5;

    //影响相关trigger
    static $TRIGGER_EFFECT_NORMAL = 6;
    static $TRIGGER_EFFECT_ONE = 7;
    static $TRIGGER_EFFECT_ALL = 8;

    public function run($normId,$normValue,$normTime,$resAdd)
    {
        $this->param['normId'] = $normId;
        $this->param['normValue'] = $normValue;
        $this->param['normTime'] = $normTime;
        $this->param['resAdd'] = $resAdd;

        $this->register(self::$TRIGGER_DATA_RECEIVE_REQUEST);

        if($resAdd['errNo']!=0)
        {
            $this->register(self::$TRIGGER_DATA_FAIL_INSERT);
            return ;
        }
        else
        {
            $this->register(self::$TRIGGER_DATA_SUCCESS_INSERT);
        }

        $this->load->model('normModel');
        $this->load->model('behaviorModel');
        $this->load->helper('number');

        $resNormInfo = $this->normModel->getNormInfo($normId);
        $this->param['normInfo'] = $resNormInfo;

        if(data_compare($normValue,$resNormInfo['relation'],$resNormInfo['threshold']))
            $this->register(self::$TRIGGER_NORM_BEYOND);
        else
            $this->register(self::$TRIGGER_NORM_NORMAL);

        $resNormBehavior = $this->behaviorModel->getBehaviorByNormId($normId);
        foreach($resNormBehavior as $key=>$val)
        {
            $resTask = $this->behaviorModel->getTaskInfo($val['id'],$val['taskType']);
            if($resTask)
            {
                if(array_search($val['trigger'],$this->triggerArr))
                {
                    $this->param['behaviorId'] = $val['id'];
                    $this->param['taskId'] = $resTask['id'];
                    switch($val['taskType'])
                    {
                        case self::$TASK_TYPE_EMAIL :
                            $this->runJob($val['id'],'email');
                            break;
                        default:
                    }
                }
            }
        }
    }

    public function runJob($behaviorId,$jobName)
    {
        $this->load->model('behaviorModel');

        $data = array(
            'behaviorId' => $behaviorId,
            'name' => $jobName,
            'param' => json_encode($this->param),
            'createTime' => time(),
        );
        $resJobId = $this->behaviorModel->addJob($data);
        if(!$resJobId)
            return $this->returnMsg(101,'注册job失败');

        $this->config->load('behavior');
        $url = $this->config->item('jobUrl');
        $port = $this->config->item('jobPort');

        $out = "GET /job/run?jobId={$resJobId} HTTP/1.1\r\n";
        $out .= "Host: {$url}\r\n";
        $out .= "Cookie:XDEBUG_SESSION=XDEBUG_ECLIPSE\r\n\r\n";

        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $resConnect = socket_connect($sock,$url,$port);

        if($resConnect)
        {
            socket_write($sock,$out);
            $res = socket_read($sock,1000);
            echo $res;
            $this->sockPool[] = $sock;
        }
    }


    /*public function runJob()
    {
        $this->config->load('behavior');
        $url = $this->config->item('jobUrl');

        $this->sock =  socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect($this->sock,$url,80);

        if($this->sock)
        {
            foreach ($this->out as $key=>$val)
            {
                socket_write($this->sock,$val);
                $res = socket_read($this->sock,1000);
                var_dump($res);
            }
        }
    }*/

    private function register($trigger)
    {
        $this->triggerArr[] = $trigger;
    }

    public function __destruct()
    {
        foreach($this->sockPool as $key=>$val)
        {
            socket_close($val);
        }
    }

}