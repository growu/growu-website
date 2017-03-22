@extends('layouts.app')

@section('title', 'Page Title')

@section('content')

<!-- INTRO COUNTDOWN BLOCK -->
<header id="intro-countdown" class="cover-bg no-sep text-center bg-color1 dark-bg" style="background-image:url(img/bg41.jpg)" data-selector="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img class="sep-bottom" src="img/icon.jpg" alt="" height="120" width="120" data-selector="img">
                <h2 class="sep-bottom big-title" data-selector="h2">即将到来</h2>
                <div>
                    <div class="countdown" data-selector=".countdown">
                        <div>
                            <div class="days">10</div>
                            <em class="textDays">天</em>
                        </div>
                        <div>
                            <div class="hours">31</div>
                            <em class="textHours">小时</em>
                        </div>
                        <div>
                            <div class="minutes">26</div>
                            <em class="textMinutes">分</em>
                        </div>
                        <div>
                            <div class="seconds">43</div>
                            <em class="textSeconds">秒</em>
                        </div>
                    </div>
                </div>
                <p class="desc-text" data-selector="p">我们正在努力建设，以给你展现最优质的内容，敬请期待！</p>
            </div>
        </div>
    </div>
</header>
@endsection


