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
        if($request->input("echostr")) {
            $this->weibo->valid();
        }
    }
}