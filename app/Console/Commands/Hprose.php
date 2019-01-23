<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Hprose\Swoole\Server;
use Illuminate\Support\Facades\Redis;

function hello($name) {
    return "Hello $name!";
}


class Hprose extends Command
{
    private $_message;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hprose';

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $redis = Redis::connection();
        $redis -> subscribe("channel1",function($message){
           $this->_message = $message;
        });
        echo $this->_message;
        $result = $redis->lpush('message',[$this->_message]);
        var_dump($result);
    }
}
