<?php
/**
 * Created by PhpStorm.
 * User: tuo3
 * Date: 2017/3/23
 * Time: 下午11:39
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\Wb;
use App\Libraries\Weibo;
use Illuminate\Support\Facades\Input;

class WeiboController extends Controller
{

    protected $weibo;
    protected $wb;

    public function __construct()
    {
        $key = Input::get('key', false);

        if (strlen($key) != 16) {
            return "非法的URL";
        }

        $this->wb = Wb::where('key', $key)->first();

        if (!$this->wb || !($this->wb->config)) {
            return "参数未配置";
        }

        $this->weibo = new Weibo($this->wb->config);
    }

    public function index(Request $request)
    {
        if ($request->input("echostr")) {
            $this->weibo->valid();
        }

        $type = $this->weibo->getRev()->getRevType();

        switch ($type) {
            case Weibo::MSGTYPE_TEXT:
                switch ($type) {
                    case Weibo::MSGTYPE_TEXT:
                        $this->weibo
                            ->text($this->weibo->getRevContent())
                            ->reply();
                        return;
                        break;
                    case Weibo::MSGTYPE_EVENT:
                        $eventData = $this->weibo->getRevData();
                        if ($eventData['subtype'] == Weibo::EVENT_FOLLOW) {
                            $this->weibo
                                ->text('你好，第'.$this->wb->visits.'位朋友，欢迎来到格吾社区！
                
我们正努力打造成为一个高质量的学习和成长型社群，
让你在这里能够发现和历炼成为更好的自己。
                
社区正在建设中，我们会不断完善和改进，欢迎提出宝贵的意见。
                
你也可以加入我们的QQ群（7852084）或者关注我们的微信公众号：格吾社区（growuu），获取更多的信息和结识更多的伙伴。')
                                ->reply();
                        } else if ($eventData['subtype'] == Weibo::EVENT_UNFOLLOW) {
                            $this->weibo
                                ->text("相见不如怀念")
                                ->reply();
                        } else if ($eventData['subtype'] == Weibo::EVENT_CLICK) {
                            $content = $this->paraseEventKey($eventData['key']);
                            $this->weibo
                                ->text($content)
                                ->reply();
                        }
                        return;
                        break;
                    case Weibo::MSGTYPE_MENTION:
                        $this->weibo->text("你的 @ 我已经收到，稍后会回复给你")->reply();
                        return;
                        break;
                }
                break;
            default:
                $this->weibo
                    ->text("Sorry,我不能识别这条信息！")
                    ->reply();
                return;
                break;
        }
    }

    protected function paraseEventKey($key)
    {
        // 获取具体的KEY
        switch ($key) {
            case 'menu_booklist':
                return '书单整理中，稍后公布。';
                break;
            case 'menu_checkin':
                return '想要早起、读书、运动或者更多，微信号：foxmee';
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
     * 创建菜单
     */
    public function create_menu()
    {
        $buttons = [
            [
                "name"       => "格",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "书单",
                        "key"  => "menu_booklist"
                    ],
                    [
                        "type" => "click",
                        "name" => "打卡",
                        "key"  => "menu_checkin"
                    ],
                ],
            ],
            [
                "name"       => "吾",
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
        $this->weibo->createMenu($buttons);
    }
}