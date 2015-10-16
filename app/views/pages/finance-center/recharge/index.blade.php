
@extends('layouts.submaster')


@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/finance-center/recharge/index.css">
@stop

@section('js')
@parent
<script type="text/javascript" src="/dist/js/pages/finance-center/recharge/index.js"></script>
@stop

@section('left-nav')
    @include('components.left-nav.finance-center-left-nav')
@stop

@section('right-content')
<div class="recharge-wrap">
    <div class="recharge-body">
        <p class="balance-wrap">
            <span class="label">账户余额:</span>
            <span class="balance">{{{ $account_info['balance'] }}}</span>
        </p>
        <br/>
        <p>
            <span class="desc">账户余额仅可以抵扣数据查询费用；单次充值金额不低于50元，且为整数。</span>
        </p>
        <p>
            <span class="desc"></span>
        </p>
        <p class="amount-wrap">
            <span class="label">充值金额:</span>
            <input type="text" id="amount-input" class="amount-input">
            <span class="unit">元</span>
        </p>
        <div class="pay-wrap clearfix">
            <button class="pay-btn pay-wx" id="pay-wx">
                <img src="/images/serve/wechat.png" class="pay-icon">
                <span class="pay-txt">微信支付</span>
            </button>
            <button class="pay-btn pay-ali" id="pay-ali">
                <img src="/images/serve/zhifubao.png" class="pay-icon">
                <span class="pay-txt">支付宝支付</span>
            </button>
        </div>
    </div>
</div>
@stop