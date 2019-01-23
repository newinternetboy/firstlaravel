<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisWebSocketServer extends Command
{
    private $_serv;

    private $_redis;

    private $_message;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis-websocket-server';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_serv = new \Swoole\Websocket\server("0.0.0.0", 8100);
        $this->_serv->set([
            'worker_num' => 1,
        ]);
        $this->_serv->on('open', [$this, 'onOpen']);
        $this->_serv->on('message', [$this, 'onMessage']);
        $this->_serv->on('close', [$this, 'onClose']);
        $this->_redis = Redis::connection();
    }

    public function onOpen($serv, $request)
    {
        echo "server: handshake success with fd{$request->fd}.\n";
    }

    /**
     * @param $serv
     * @param $frame
     */
    public function onMessage($serv, $frame)
    {
        foreach ($serv->connections as $fd){
            $serv->push($fd, "server-fd:{$fd},server received data :{$frame->data}");
        }
    }

    public function onClose($serv, $fd)
    {
        echo "client {$fd} closed.\n";
    }

    public function start()
    {
        $this->_serv->start();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->start();
    }
}
