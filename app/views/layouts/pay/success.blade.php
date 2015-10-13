@extends('layouts.submaster')

@section('title')
    支付成功
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/common/pay/success.css">
@stop

@section('right-content')
<div class="pay-wrap">
    <div class="pay-body">
        @yield('flow')
        @include('layouts.pay.info')
        <div class="notice">
            <img src="/images/common/wzdb_10.png">
            <p>支付成功</p>
        </div>
    </div>
</div>
@stop