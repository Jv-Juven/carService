@extends('layouts.submaster')

@section('title')
    充值 --- 微信支付
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/common/pay/wechat.css">
@stop

@section('right-content')
<div class="pay-wrap">
    <div class="pay-body">
        @include('layouts.pay.info')
        <div class="pay-qrcode notice">
            <img src="/images/common/qrcode.png">
            <p>请使用微信扫一扫完成支付</p>
        </div>
    </div>
</div>
@stop