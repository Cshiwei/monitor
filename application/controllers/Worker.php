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

    public function httpRun()
    {
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

    public function taskRun()
    {
        $task = new swoole_server('0.0.0.0', 9505);   // 允许所有IP访问
        $task->set(array(
            'worker_num' => 4,   // 一般设置为服务器CPU数的1-4倍
            'task_worker_num' => 1,  // task进程的数量（一般任务都是同步阻塞的，可以设置为单进程单线程）
            'daemonize' => False,  // 以守护进程执行
            'package_eof' => PHP_EOL,  // 设置EOF
            'open_eof_split' => true,  // 按照EOF进行分包，防止TCP粘包
            //  'task_ipc_mode' => 1,  // 使用unix socket通信，默认模式
            //  'log_file' => '/data/log/queue.log' ,    // swoole日志

            // 数据包分发策略（dispatch_mode=1/3时，底层会屏蔽onConnect/onClose事件，
            // 原因是这2种模式下无法保证onConnect/onClose/onReceive的顺序，非请求响应式的服务器程序，请不要使用模式1或3）
            //  'dispatch_mode' => 2,        // 固定模式，根据连接的文件描述符分配worker。这样可以保证同一个连接发来的数据只会被同一个worker处理
        ));

        $task->on('WorkerStart', array($this, 'onWorkerStart'));
        $task->on('Receive',array($this,'onReceive'));
        $task->on('Task', array($this,'onTask'));
        $task->on('Finish', array($this,'onFinish'));
        $task->start();
    }

    public function onReceive($serv, $fd, $from_id, $data )
    {
        $str  = "=========== onReceive ============ \n";
        $str .= "Get Message From Client $fd:$data \n";
        echo $str;
        $serv->task( $data );
    }

    public function onTask($serv, $task_id, $src_worker_id, $data)
    {
        $data   = trim($data);
        $param  = json_decode( $data , true );
        $str    = "=========== onTask ============ \n";
        $str   .= var_export($param, 1);
        echo $str;
        log_message('debug','接到任务请求');
        $jobId = $param['jobId'];
        $resJob = $this->runJob($jobId);
        return $resJob;
    }

    public function onFinish($serv, $task_id, $data)
    {
        $str  = "=========== onFinish ============ \n";
        $str .= "Task $task_id finish ! \n";
        $str .= var_export($data, 1);
        echo $str;
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
        $resJob = $this->runJob($jobId);
        $response->end(json_encode($resJob));
    }

    public function runJob($jobId)
    {
        log_message('debug',"获取到任务ID{$jobId}");
        $this->load->logic('jobLogic');
        $resJob = $this->jobLogic->run($jobId);
        log_message('debug',"执行完毕".serialize($resJob));
        if($resJob['errNo']!=0)
            log_message('error',$resJob['errMsg']);

        return $resJob;
    }
}