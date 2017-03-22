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

class WechatController extends Controller
{

    protected $wechat;

    public function __construct()
    {
        $key = Input::get('key', false);
        $mp = Mp::where('key',$key)->first();
        $options = json_decode($mp->config,TRUE);
        $this->wechat = new Application($options);
    }

    public function index(Request $request, $key)
    {
        if($request->input('echostr')) {
            $this->validate();
        }

        $this->wechat->server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            switch ($message->MsgType) {
                case 'event':
                    // 解析时间类型
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });

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
                break;
            case 'unsubscribe':
                break;
        }
    }

    /**
     * 验证
     *
     * @return string
     */
    public function validate()
    {
        Log::info('wechat server validate.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

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