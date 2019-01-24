<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class User extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:user';

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
/*        $u_id = range(1,200);
        $this->_redis->lpush('users',$u_id);*/
/*        $buied_user_list_len = $this->_redis->llen('users_buied');
        $buied_user_list = $this->_redis->lrange("users_buied",0,$buied_user_list_len);
        var_dump($buied_user_list);*/
        $result = $this->_redis->lpop('caoxiang');
        var_dump($result);
    }
}
