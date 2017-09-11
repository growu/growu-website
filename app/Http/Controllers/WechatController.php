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
                            'description' => '更新至2017年5月',
                            'url'         => 'http://mp.weixin.qq.com/s/3Md8HOoyTz1X2dIIC9QPdQ',
                            'image'       => 'https://mmbiz.qlogo.cn/mmbiz_png/Sh6Ndnnr9galox1Mlic0GtshicF0QHliawFDkekMT44T6mKeeQR2VkKicXpg15icGZC7wtdrJwXKHFjccCNalMqqoUQ/0?wx_fmt=png',
                            // ...
                        ]);

                        return [$news];
                    } else if(strstr($keyword,"会员")) {
                        $news = new News([
                            'title'       => '「格吾会员」正式说明',
                            'description' => '1000个铁杆粉丝',
                            'url'         => 'http://mp.weixin.qq.com/s/NxsRRkZiRwGOeAbkUi513w',
                            'image'       => 'https://mmbiz.qlogo.cn/mmbiz_jpg/Sh6Ndnnr9gYVxOX4ssCfyTe2D5Gd7Micle4u8cvu653KcaQlDt8c9MoXuZGe1nN1Togvv33fh9Tcic9lMUYLxrGw/0?wx_fmt=jpeg',
                            // ...
                        ]);

                        return [$news];
                    } else if(strstr($keyword,"早起")) {
                        $news = new News([
                            'title'       => '格吾「早起」训练营第1期招募公告',
                            'description' => '时间：2017.5.15日-2017.6.3日',
                            'url'         => 'http://mp.weixin.qq.com/s/S4X_8sf2-yG_HnmuL1EUiQ',
                            'image'       => 'https://mmbiz.qlogo.cn/mmbiz_jpg/Sh6Ndnnr9gZbOncVErjcnqJSUl3ChTibJgeibLib1ggpLn9SN1ibgnFFSKNS1IrUkZ345XW6cPtDdic8jLWOjeLI2Iw/0?wx_fmt=jpeg',
                            // ...
                        ]);

                        return [$news];
                    } else if(strstr($keyword,"运动")) {
                        $news = new News([
                            'title'       => '格吾「运动」训练营第1期招募公告',
                            'description' => '时间：2017.5.22日-2017.6.11日',
                            'url'         => 'http://mp.weixin.qq.com/s/7WWa0xws8sngsoSvMwdlcQ',
                            'image'       => 'https://mmbiz.qlogo.cn/mmbiz_jpg/Sh6Ndnnr9gaDhkNGY3lvpvQmO8QIypyyDHE4IuVE2nkPWLGQUrkwmgK2pcia3xVckBsa1ZQdInE5wFHyBgFJUOw/0?wx_fmt=jpeg',
                            // ...
                        ]);

                        return [$news];
                    } else if(strstr($keyword,"俱乐部")) {
                        $news = new News([
                            'title'       => '格吾「俱乐部」正式说明',
                            'description' => '找到志同道合的小伙伴',
                            'url'         => 'http://mp.weixin.qq.com/s/7nXsv-fjgs83ymwCjnSTCA',
                            'image'       => 'https://mmbiz.qlogo.cn/mmbiz_jpg/Sh6Ndnnr9ga4rHbEMNtib2ofAmpGjluvicfsg3Z5lnzO9fG4zm4apHKvFHoXRgObdjMqCyIe6Lv3G1vibzcbTjRTQ/0?wx_fmt=jpeg',
                        ]);

                        return [$news];
                    }

                    return '你的消息我们已经收到，稍后将由格吾君亲自为你解答';
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
                return '你好，新朋友！
欢迎来到格吾社区。
              
我们正努力打造一个高质量的学习和成长型社群，希望在这里让你找到志同道合的小伙伴以及历练成为更好的自己。

点击下方的菜单，发现更多可能。
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
                    'description' => '更新至2017年6月',
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

            case 'menu_club':

                $news = new News([
                    'title'       => '格吾「俱乐部」正式说明',
                    'description' => '找到志同道合的小伙伴',
                    'url'         => 'http://mp.weixin.qq.com/s/7nXsv-fjgs83ymwCjnSTCA',
                    'image'       => 'https://mmbiz.qlogo.cn/mmbiz_jpg/Sh6Ndnnr9ga4rHbEMNtib2ofAmpGjluvicfsg3Z5lnzO9fG4zm4apHKvFHoXRgObdjMqCyIe6Lv3G1vibzcbTjRTQ/0?wx_fmt=jpeg',
                ]);

                return [$news];
                break;
            case 'menu_topic':
                return '说一说#你坚持最久最有意义的事情#';
                break;
            case 'menu_checkin':
                return '为了帮助小伙伴们更好地培养兴趣和习惯，我特别开设了21天打卡训练营活动，欢迎有兴趣的朋友加入：，公众号内回复关键字 早起 运动 了解更多。';
                break;
            case 'menu_about':
                $news = new News([
                    'title'       => '关于我们',
                    'description' => '格物致知，知行合一',
                    'url'         => 'http://mp.weixin.qq.com/s/m1iVp0LiY_nohd-_xlRsbA',
                    'image'       => 'https://mmbiz.qlogo.cn/mmbiz_jpg/Sh6Ndnnr9gb0Mp6ZpoN3tgrib2Alib15xuMHACH5QzCGz5ASrsVqAv72realW4psuWltqWxEiaeatGI9qGkzCQf0g/0?wx_fmt=jpeg',
                ]);

                return [$news];
                break;
            case 'menu_team':
                $news = new News([
                    'title'       => '团队成员',
                    'description' => '我们是谁？',
                    'url'         => 'http://mp.weixin.qq.com/s/LqaDy7kyyqywzbiGD-cp0g',
                    'image'       => 'https://mmbiz.qlogo.cn/mmbiz_jpg/Sh6Ndnnr9gb0Mp6ZpoN3tgrib2Alib15xuUZbMtHFv4HXB5wkPcLoyZXzANwVTK5ZCe8Iicw5AzCibA4k70Mhoiat9Q/0?wx_fmt=jpeg',
                ]);
                return [$news];
                break;
            case 'menu_concat':
                return 'QQ群：7852084，微博：<a href="http://weibo.com/growu">@格物社区</a>';
                break;
            case 'menu_join':
                $news = new News([
                    'title'       => '1000个铁杆粉丝',
                    'description' => '关于「格吾会员」的一些说明',
                    'url'         => 'http://mp.weixin.qq.com/s/NxsRRkZiRwGOeAbkUi513w',
                    'image'       => 'https://mmbiz.qlogo.cn/mmbiz_jpg/Sh6Ndnnr9gYVxOX4ssCfyTe2D5Gd7Micle4u8cvu653KcaQlDt8c9MoXuZGe1nN1Togvv33fh9Tcic9lMUYLxrGw/0?wx_fmt=jpeg',
                ]);

                return [$news];
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
                "name"       => "📖",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "历史消息",
                        "key"  => "menu_history",
                        "url"  => 'https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI0OTc5Njg2MQ==&scene=124#wechat_redirect'
                    ],
                    [
                        "type" => "click",
                        "name" => "书单汇总",
                        "key"  => "menu_booklist"
                    ],
                ],
            ],
            [
                "name"       => "👣",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "训练营",
                        "key"  => "menu_camp"
                    ],
                    [
                        "type" => "click",
                        "name" => "社群",
                        "key"  => "menu_club"
                    ],
                    [
                        "type" => "click",
                        "name" => "工作坊",
                        "key" => "menu_workshop"
                    ],
                    [
                        "type" => "view",
                        "name" => "水滴打卡",
                        "key"  => "menu_drip",
                        "url"  => "http://a.app.qq.com/o/simple.jsp?pkgname=me.growu.drip"
                    ],
                ],
            ],
            [
                "name"       => "👪",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "关于我们",
                        "key"  => "menu_about",
                    ],
                    [
                        "type" => "click",
                        "name" => "团队成员",
                        "key"  => "menu_team"
                    ],
                ],
            ],
        ];
        $menu->add($buttons);
    }
}