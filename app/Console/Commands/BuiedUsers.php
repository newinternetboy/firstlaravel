<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class BuiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:buied:user';

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
        $u_id = range(1,100);
        $this->_redis->lpush('users_buied',$u_id);
    }
}
