@extends('layouts.master')

@section('title')
    信息反馈
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/register-b/success/success.css">
@stop

@section('js')
@stop

@section('body')

@include("components.reg-process", array("num" => "4"))

<div class="ss-wrap">
    <img src="/images/common/wzdb_10.png" class="ss-img">
    <p class="ss-note">
        注册成功 等待审核中...
    </p>
    <p class="ss-msg">
        我们将在一个工作日内完成审核，请在3天内让贵公司的财务单位与我们沟通获得打款验证码，以激活账号
    </p>
    <!-- <p class="ss-notice">
        将在<span class="count-down">5秒</span>内跳转
    </p> -->
    <!-- <button class="ss-cfm"> -->
        <a class="btn" href="/user/write-code">填写打款码</a>
    <!-- </button> -->
</div>
@stop

@section("js")
    @parent
@stop