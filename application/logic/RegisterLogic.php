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

    static $BEHAVIOR_TYPE_SYS = 1;
    static $BEHAVIOR_TYPE_CUSTOMIZE = 2;

    static $JOB_TYPE_METHOD = 1;
    static $JOB_TYPE_SCRIPT = 2;

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

        $resSysBehavior = $this->behaviorModel->getSysBehavior();
        $resNormBehavior = $this->behaviorModel->getBehaviorByNormId($normId);

        $behavior = array_merge($resSysBehavior,$resNormBehavior);

        if($behavior)
        {
            foreach($behavior as $key=>$val)
            {
                if(array_search($val['trigger'],$this->triggerArr))
                {
                    $this->param['behaviorId'] = $val['id'];
                    switch($val['jobType'])
                    {
                        case self::$JOB_TYPE_METHOD :
                            $this->runJob($val['jobName']);
                            break;
                        case self::$JOB_TYPE_SCRIPT :
                            break;
                        default:
                    }
                }
            }
        }

    }

    public function runJob($jobName)
    {
        $this->config->load('behavior');
        $url = $this->config->item('jobUrl');

        $paramStr = 'param='.json_encode($this->param);
        $length = mb_strlen($paramStr);

        $out = "POST /job/run?jobName={$jobName} HTTP/1.1\r\n";
        $out .= "Host: {$url}\r\n";
        $out .= "Cookie:XDEBUG_SESSION=XDEBUG_ECLIPSE\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "Content-length: {$length}\r\n";
        $out .= "Connection: keep-alive\r\n\r\n";
        $out .= "{$paramStr}";

        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $resConnect = socket_connect($sock,$url,80);

        if($resConnect)
        {
            socket_write($sock,$out);
            $this->sockPool[] = $sock;
        }
        //$this->out[]=$out;
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