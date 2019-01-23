<?php
/**
 * Created by IntelliJ IDEA.
 * User: philipp
 * Date: 2019-01-23
 * Time: 14:02
 */

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PubSubController extends Controller
{
    private $redis;
    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    public function index(){
        return view('pubsub.Index');
    }
    //发送
    public function pub(Request $request){
        $message = $request->input('message');
        $channels = $this->channels();
        $count = count($channels);
        if(empty($count)){
            echo "暂无活跃的频道可以推送消息";
        }else{
            //向随机的频道发送消息
            foreach ($channels as $channel){
                $published = $this->redis->publish($channel,$message);
                var_dump($published);
            }
        }
    }

    //当前活跃的频道
    public function channels(){
        $channels = $this->redis->pubsub('channels');
        return $channels;
    }
}