
@extends('layouts.submaster')

@section('title')
    充值
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/finance-center/recharge/index.css">
@stop

@section('js')
@stop

@section('left-nav')
    @include('components.left-nav.finance-center-left-nav')
@stop

@section('right-content')
<div class="recharge-wrap">
    <div class="recharge-body">
        <p class="balance-wrap">
            <span class="label">账户余额:</span>
            <span class="balance">100</span>
            <span class="desc">账户余额仅可以抵扣数据查询费用</span>
        </p>
        <p class="amount-wrap">
            <span class="label">充值金额:</span>
            <input type="text" class="amount-input">
            <span class="unit">元</span>
        </p>
        <div class="pay-wrap clearfix">
            <button class="pay-btn pay-wx">
                <img src="/images/serve/wechat.png" class="pay-icon">
                <span class="pay-txt">微信支付</span>
            </button>
            <button class="pay-btn pay-ali">
                <img src="/images/serve/zhifubao.png" class="pay-icon">
                <span class="pay-txt">支付宝支付</span>
            </button>
        </div>
    </div>
</div>
@stop