<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/4
 * Time: 14:09
 */
class Worker extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

    }

    public function run()
    {
        define('CISWOOLE', TRUE);
        $http = new swoole_http_server("0.0.0.0", 9505);
        $http->set (array(
            'worker_num' => 8,		//worker进程数量
            'daemonize' => False,	//守护进程设置成true
            'max_request' => 10000,	//最大请求次数，当请求大于它时，将会自动重启该worker
            'dispatch_mode' => 1,
        ));
        $http->on('WorkerStart', array($this, 'onWorkerStart'));
        $http->on('request', array($this, 'onRequest'));
        $http->on('start', array($this, 'onStart'));
        $http->start();
    }

    /**
     * server start的时候调用
     * @param unknown $serv
     */
    public function onStart($serv)
    {
        echo 'swoole version'.swoole_version().PHP_EOL;
    }
    /**
     * worker start时调用
     * @param unknown $serv
     * @param int $worker_id
     */
    public function onWorkerStart($serv, $worker_id)
    {
        global $argv;
        if($worker_id >= $serv->setting['worker_num']) {
            swoole_set_process_name("php {$argv[0]}: task");
        } else {
            swoole_set_process_name("php {$argv[0]}: worker");
        }
        echo "WorkerStart: MasterPid={$serv->master_pid}|Manager_pid={$serv->manager_pid}|WorkerId={$serv->worker_id}|WorkerPid={$serv->worker_pid}\n";
    }

    /**
     * 当request时调用
     * @param unknown $request
     * @param unknown $response
     */
    public function onRequest($request, $response)
    {
        log_message('debug','接收到任务请求');
        $jobId = $request->get['jobId'];
        log_message('debug',"获取到任务ID{$jobId}");
        $this->load->logic('jobLogic');
        $resJob = $this->jobLogic->run($jobId);
        log_message('debug',"执行完毕".serialize($resJob));
        if($resJob['errNo']!=0)
            log_message('error',$resJob['errMsg']);

        $response->end(json_encode($resJob));
    }
}