<?php
/**
 * Created by IntelliJ IDEA.
 * User: philipp
 * Date: 2019-01-21
 * Time: 19:35
 */

namespace App\Http\Controllers;
use function foo\func;
use Hprose\Future;
use Hprose\Promise;
use Hprose\Completer;
use mysql_xdevapi\Exception;

class HproseController extends Controller
{
    public function index(){
        // Hprose\Future
        // 6个工厂方法
        // resolve/value
        // reject/error
        // sync(Future含参构造)
        // promise(返回的是Future对象)，Promise构造方法返回一个promise对象， Promise类是Future的子类
/*
 *         fulfilled
 *         $promise = new Future(function(){
            return 'hprose';
        });
        $promise -> then(function($value){
            var_dump($value);
        });*/


/*
 *         rejected
 *         $promise = new Future(function(){
            throw new \Exception('hprose');
        });
        $promise -> catchError(function($reason){
            var_dump($reason->getMessage());
        });*/


/*
 *         fulfilled
 *         value()实现的promise对象同上Future实现的对象一样，但是更简单
 *         $promise = Future\value('hprose-promise-obj');
        $promise -> then(function($value){
            var_dump($value);
        });*/

/*
 *         error()方法实现的rejected状态的promise对象同Future创建的一样
 *         $e = new \Exception('hprose-exception');
        $promise = Future\error($e);
        $promise ->catchError(function($value){
            var_dump($value->getMessage());
        });*/

        //Future/sync 创建一个同步的promise对象



/*        promise()方法创建promise对象，参数成功和失败的回调
          $p = Future\promise(function ($resolve, $reject){
            $a = 1;
            $b = 2;
            if($a == $b){
                $resolve('ok');
            }else{
                $reject(new \Exception("Exception:$a ! = $b"));
            }
        });
        if($p -> state == Future::FULFILLED){
            $p -> then(function($value){
                var_dump($value);
            });
        }

        if($p -> state == Future::REJECTED){
            $p -> catchError(function ($value){
                var_dump($value->getMessage());
            });
        }*/

/*
 *         Future\Promise 实例promise对象
 *         //使用Promise类进行实例化promise对象,参数$resolve,$reject
        $p = new Promise(function($resolve, $reject){
            $fulfilled = true;
            if($fulfilled){
                $resolve("class-promise-new");
            }else{
                $reject(new \Exception("class-promise-new-failed"));
            }
        });

        if($p->state == Promise::FULFILLED){
            $p -> then(function($value){
                var_dump($value);
            });
        }

        if($p -> state == Promise::REJECTED){
            $p -> catchError(function($e){
                var_dump($e -> getMessage());
            });
        }*/

/*        // Hprose\Completer 创建promise对象
        $completer = new Completer();
        $promise = $completer -> future();
        $promise -> then(function($value){
            var_dump($value->getMessage());
        });//在这之前，completer 实例化的completer对象可以通过future方法实例化出promise对象，但是现在的promise对象更像一个空的框架，等待complete方法填充值

        $promise -> catchError(function($value){
            var_dump($value -> getMessage());
        });
        // complete 方法执行之后(无论完成的值是正确的值还是异常)，当前promise对象的state属性就成了fulfilled状态
        // completeError 方法可以设置失败值
        var_dump($completer -> isCompleted());
        var_dump($promise -> state);
//        $completer ->complete('Completer implement promise');
        $completer -> completeError(new \Exception('Exception:completer new failed'));
        var_dump($completer -> isCompleted());*/


    /*******************************Future类上的方法************************************************/
    //then()方法,两个参数$onfulfill，$onreject都应该是可回调的，$onfulfill只有在最终的promise对象是fulfilled才会调用，$onreject在最终的promise对象是rejected才会调用
        (new Future(function(){/*return '链式调用';*/ throw new \Exception('then method reject data');})) -> then(function($value){
            var_dump($value);
        },function($e){
            var_dump($e -> getMessage());
        });
    }
}