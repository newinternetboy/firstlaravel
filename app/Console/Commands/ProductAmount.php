<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ProductAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:product:amount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $_redis;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_redis = Redis::connection();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $amount = 300;
        for($i=1;$i<=300;$i++){
            $this->_redis->lpush("product-amount",1);
        }
    }
}
