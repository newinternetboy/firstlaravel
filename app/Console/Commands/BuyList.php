<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class BuyList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:buy:list';

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
        while(true){
            $product_len = $this->_redis->llen("product-amount");
            if(empty($product_len)){
                echo "产品已卖完";
                break;
            }else{
                //从抢购列队中取出用户(两百个用户)
                $uid = $this->_redis->lpop('users');
                if(!isset($uid)){
                    echo "暂无抢购用户";
                    break;
                }
                //用户是否已经抢购成功过
                $buied_user_list_len = $this->_redis->llen("users_buied");
                $buied_user_list = $this->_redis->lrange("users_buied",0,$buied_user_list_len);
                if(in_array($uid,$buied_user_list)){
                    echo "uid为{$uid}的用户已经抢购过了，不能二次抢购!\n";
                }else{
                    //将库存减1
                    $this->_redis->lpop('product-amount');
                    //将该用户存入已抢购用户的列队
                    $this->_redis->lpush('users_buied',$uid);
                    echo "uid为{$uid}的用户请购成功\n";
                }
            }
        }
    }
}
