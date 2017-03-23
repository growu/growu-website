<?php
/**
 * Created by PhpStorm.
 * User: Jason.z
 * Date: 2017/3/16
 * Time: 下午7:03
 */

namespace App\Http\Controllers;

use Log;
use App\Models\Mp;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class WechatController extends Controller
{

    protected $wechat;
    protected $mp;

    public function __construct()
    {
        $key = Input::get('key', false);

        if(strlen($key) != 16) {
            echo "非法的URL";exit;
        }

        $this->mp = Mp::where('key',$key)->first();

        if(! $this->mp || !($this->mp->config)) {
            echo "参数未配置";exit;
        }

        $options = json_decode($this->mp->config,TRUE);
        $this->wechat = new Application($options);
    }

    public function index()
    {
        Log::info(http_build_query($_REQUEST));

        $this->wechat->server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            switch ($message->MsgType) {
                case 'event':
                    // 解析时间类型
                    return $this->parseEvent($message);
                    break;
                case 'text':
                    return '你的信息我已收到！';
                    break;
                case 'image':
                    return '嗯，这个图片很美。';
                    break;
                case 'voice':
                    return '嗯，这个声音很好听。';
                    break;
                case 'video':
                    return '嗯，这个视频很不错。';
                    break;
                case 'location':
                    return '嗯，我知道你在哪儿了。';
                    break;
                case 'link':
                    return '嗯，我是不会打开的。';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });

        return $this->wechat->server->serve();

    }

    /**
     * Set the default driver name.
     *
     * @param  object  $message
     * @return object
     */
    protected function parseEvent($message)
    {
        switch ($message->Event) {
            case 'subscribe':
                return '初次见面，多多关照，在这里，不谈风花雪月，只论学习成长，如果你有问题，下面的菜单可能会帮到你。';
                break;
            case 'unsubscribe':
                return '相见不如怀念，祝君好运。';
                break;
        }
    }

    /**
     * 验证
     *
     * @return string
     */
    public function valid()
    {
        Log::info('wechat server valid.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $response = $this->wechat->server->serve();

        Log::info('return response.');

        return $response;

//        $wechat->server->setMessageHandler(function($message){
//            return "欢迎关注 overtrue！";
//        });
//
//
//        return $wechat->server->serve();
    }
}