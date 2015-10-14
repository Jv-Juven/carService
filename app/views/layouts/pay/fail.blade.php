@extends('layouts.submaster')

@section('title')
    支付失败
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/common/pay/fail.css">
@stop

@section('right-content')
<div class="pay-wrap">
    <div class="pay-body">
        @yield('flow')
        @include('layouts.pay.info', [ 'order' => $order ])
        <div class="notice">
            <img src="">
            <p>您的订单未能支付成功，请重新支付！</p>
            <button class="repay-btn">
                <a href="/serve-center/agency/pages/pay?order_id={{{ $order->order_id }}}">重新支付</a>
            </button>
        </div>
    </div>
</div>
@stop