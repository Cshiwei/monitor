<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 15:48
 */
class Test extends CI_Controller{

    public $sockPool = array();

    public function run()
    {
        if(ENVIRONMENT == 'production')
        {
            $this->fail('无权访问该页面！');
        }
        else
        {
            $method = $this->input->get('m');
            $this->$method();
        }
    }

    private function testBehavior()
    {
        $this->load->logic('normLogic');
        $this->load->logic('registerLogic');

        $normId = 191;
        $normValue = 8;
        $normTime = 1528096190;

        //$resAdd = $this->normLogic->addNormCensus($normId,$normValue,$normTime);
        $resAdd = array('errNo'=>0,'errMsg'=>'');
       /* header('Content-type:application/json');
        echo json_encode($resAdd);*/
        $this->registerLogic->run($normId,$normValue,$normTime,$resAdd);
    }

    private function testRunJob()
    {
        $this->load->logic('registerLogic');
        $normId=3;
        $normValue=1000;
        $normTime=time();
        $resAdd = array('errNo'=>0);
        $this->registerLogic->run($normId,$normValue,$normTime,$resAdd);
    }

    private function testOpen()
    {
        echo 666;
        $this->load->model('normModel');
        $data = array(
            'name' => 'test'
        );
        //sleep(6);
        $this->normModel->addNorm($data);
    }

    private function testEmail()
    {
        $this->load->library('email');            //加载CI的email类

        //以下设置Email内容
        $this->email->from('caoshiwei@lightinthebox.com', 'caoshiwei');
        $this->email->to('caoshiwei@lightinthebox.com');
        $this->email->subject('Email Test');
        $this->email->message('<font color=red>Testing the email class.</font>');
        $this->email->set_newline("\r\n");

        $this->email->send();
        echo $this->email->print_debugger();
    }

    private function addTestData()
    {
        $this->load->logic('normLogic');
        $this->normLogic->addTestData();
    }

    private function testSwoole()
    {
        $this->load->model('behaviorModel');

        //$url = 'monitor.litb-test.com';
        //$port = 9505;
        $url = 'monitor.litb-test.com';
        $port = 9505;
        $out = "GET /job/run?jobId=1 HTTP/1.1\r\n";
        $out .= "Host: {$url}\r\n";
        $out .= "Cookie:XDEBUG_SESSION=XDEBUG_ECLIPSE\r\n\r\n";

        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $resConnect = socket_connect($sock,$url,$port);

        if($resConnect)
        {
            socket_write($sock,$out);
            $this->sockPool[] = $sock;
        }
    }

    public function __destruct()
    {
        if(!empty($this->sockPool))
        {
            foreach ($this->sockPool as $key=>$val)
            {
                socket_close($val);
            }
        }

    }
}