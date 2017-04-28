<?php
/**
 * Created by PhpStorm.
 * User: Jason.z
 * Date: 2017/3/17
 * Time: 下午8:52
 */
?>
<!--
______                            _              _                                     _
| ___ \                          | |            | |                                   | |
| |_/ /___ __      __ ___  _ __  | |__   _   _  | |      __ _  _ __  __ _ __   __ ___ | |
|  __// _ \\ \ /\ / // _ \| '__| | '_ \ | | | | | |     / _` || '__|/ _` |\ \ / // _ \| |
| |  | (_) |\ V  V /|  __/| |    | |_) || |_| | | |____| (_| || |  | (_| | \ V /|  __/| |
\_|   \___/  \_/\_/  \___||_|    |_.__/  \__, | \_____/ \__,_||_|   \__,_|  \_/  \___||_|
__/ |
                                         |___/
  ========================================================
                                           --------------------------------------------------------
-->

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>@section('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="keywords" content=""/>
    <meta name="author" content="Growu"/>
    <meta name="description" content="@section('description') @show"/>
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset(mix('/css/app.css')) }}">
    <link rel="shortcut icon" href=""/>
    @yield('styles')
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?aa7608dc990f6527a175fd873d2d78b5";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body id="body" class="">

    <div id="wrap">
        @include('layouts.partials.nav')
        @yield('content')
        @include('layouts.partials.footer')
    </div>

    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>
    <script src="{{ asset(mix('js/app.js')) }}"></script>

    @yield('scripts')

    @if (App::environment() == 'production')
        <script>
            ga('create', '{{ getenv('GA_Tracking_ID') }}', 'auto');
            ga('send', 'pageview');
        </script>

        <script>
            // Baidu link submit
            (function () {
                var bp = document.createElement('script');
                var curProtocol = window.location.protocol.split(':')[0];
                if (curProtocol === 'https') {
                    bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
                }
                else {
                    bp.src = 'http://push.zhanzhang.baidu.com/push.js';
                }
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(bp, s);
            })();
        </script>
    @endif

</body>
</html>