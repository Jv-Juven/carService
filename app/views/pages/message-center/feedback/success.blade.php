@extends('layouts.submaster')

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/message-center/feedback/success.css">
@stop

@section('js')
@stop

@section('left-nav')
    @include('components.left-nav.message-center-left-nav')
@stop

@section('right-content')
<div class="ss-wrap">
    <img src="/images/common/wzdb_10.png" class="ss-img">
    <p class="ss-note">
        提交成功
    </p>
    <p class="ss-msg">
        您的反馈信息已成功提交，我们会尽快与你联系，您的支持是我们最大的动力！
    </p>
    <button class="ss-cfm"><a href="/message-center/feedback/index">确定</a></button>
</div>
@stop