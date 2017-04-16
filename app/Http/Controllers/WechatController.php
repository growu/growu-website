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
use EasyWeChat\Message\News;
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

        $this->wechat = new Application($this->mp->config);
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

                    $keyword = $message->Content;

                    if(strstr($keyword,"书单")){
                        $news = new News([
                            'title'       => '「格吾读书」共读书单汇总',
                            'description' => '更新至2017年3月',
                            'url'         => 'http://mp.weixin.qq.com/s/3Md8HOoyTz1X2dIIC9QPdQ',
                            'image'       => 'https://mmbiz.qlogo.cn/mmbiz_png/Sh6Ndnnr9galox1Mlic0GtshicF0QHliawFDkekMT44T6mKeeQR2VkKicXpg15icGZC7wtdrJwXKHFjccCNalMqqoUQ/0?wx_fmt=png',
                            // ...
                        ]);

                        return [$news];
                    }


                    return '嗯，收到';
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
     * 解析事件
     *
     * @param  object  $message
     * @return object
     */
    protected function parseEvent($message)
    {
        switch ($message->Event) {
            case 'subscribe':
                $this->mp->increment('visits');
                return '你好，第'.$this->mp->visits.'位朋友，欢迎来到格吾社区！
                
我们正努力打造成为一个高质量的学习和成长型社群，
希望能帮助你历炼成为更好的自己。

社区正在建设中，我们会不断完善和改进，欢迎提出宝贵的意见。

下方的菜单可能会有一些你感兴趣的东西，赶快去发掘吧。
                
               
你也可以加入我们的QQ群（7852084）或者关注我们的新浪微博（<a href="http://weibo.com/growu">@格吾社区</a>），获取更多的信息和结识更多的伙伴。
                ';
                break;
            case 'location':
                $location_x = $message->Location_X;  // 地理位置纬度
                $location_y = $message->Location_Y;  // 地理位置经度
                $scale = $message->Scale;       // 地图缩放大小
                $label = $message->Label;       // 地理位置信息
                return '地理位置已上报';
                break;
            case 'CLICK':
                return $this->paraseEventKey($message->EventKey);
            case 'unsubscribe':
                return '相见不如怀念，祝君好运。';
                break;
        }
    }

    /**
     * 解析菜单事件
     *
     * @param  object  $message
     * @return object
     */
    protected function paraseEventKey($key)
    {
       // 获取具体的KEY
        switch ($key) {
            case 'menu_booklist':

                $news = new News([
                    'title'       => '「格吾读书」共读书单汇总',
                    'description' => '更新至2017年3月',
                    'url'         => 'http://mp.weixin.qq.com/s/3Md8HOoyTz1X2dIIC9QPdQ',
                    'image'       => 'https://mmbiz.qlogo.cn/mmbiz_png/Sh6Ndnnr9galox1Mlic0GtshicF0QHliawFDkekMT44T6mKeeQR2VkKicXpg15icGZC7wtdrJwXKHFjccCNalMqqoUQ/0?wx_fmt=png',
                    // ...
                ]);

                return [$news];
                break;
            case 'menu_booklist2':

                $news = new News([
                    'title'       => '「格吾读书」共读书单征集',
                    'description' => '告诉我们，你想看的书',
                    'url'         => 'http://mp.weixin.qq.com/s/5S28-Zg_U-PqPIX457UJBg',
                    'image'       => 'https://mmbiz.qlogo.cn/mmbiz_png/Sh6Ndnnr9gZWrnVqQFIFFZe1wlpYm6UfYE91XQ0tupiafc4DfGdkfWgWbYK3BPJAVTKpVyXHcHQ9AFzb1Z7IFvw/0?wx_fmt=png',
                ]);

                return [$news];
                break;
            case 'menu_topic':
                return '说一说#你坚持最久最有意义的事情#';
                break;
            case 'menu_checkin':
                return '加微信foxmee，发送暗号：早起、读书、运动或者其他';
                break;
            case 'menu_about':
                return '时间会告诉你我们是谁';
                break;
            case 'menu_concat':
                return 'QQ群：7852084，微博：<a href="http://weibo.com/growu">@格物社区</a>';
                break;
            case 'menu_join':
                return '我们需要你的才华，微信号：foxmee';
                break;
            default:
                break;
        }
    }

    /**
     * 创建订单
     *
     * @param  null
     * @return null
     */
    public function create_menu()
    {
        $menu = $this->wechat->menu;

        $buttons = [
            [
                "name"       => "「格」",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "一周话题",
                        "key"  => "menu_topic"
                    ],
                    [
                        "type" => "click",
                        "name" => "书单汇总",
                        "key"  => "menu_booklist"
                    ],
                    [
                        "type" => "click",
                        "name" => "书单征集",
                        "key"  => "menu_booklist2"
                    ],
                    [
                        "type" => "click",
                        "name" => "习惯打卡",
                        "key"  => "menu_checkin"
                    ],
                ],
            ],
            [
                "name"       => "「吾」",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "关于我们",
                        "key"  => "menu_about"
                    ],
                    [
                        "type" => "click",
                        "name" => "联系我们",
                        "key"  => "menu_concat"
                    ],
                    [
                        "type" => "click",
                        "name" => "加入我们",
                        "key" => "menu_join"
                    ],
                ],
            ],
        ];
        $menu->add($buttons);
    }
}