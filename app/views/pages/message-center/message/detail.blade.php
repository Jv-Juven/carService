@extends('layouts.master')

@section('title')
    全部消息
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/message-center/message/detail.css">
@stop

@section('js')
@stop

@section('body')
<div class="message-wrap">
    <div class="message-body">
        <div class="message-content">
            <h2 class="message-title">驾驶证过期后可能会出现的三种状态</h2>
            <p class="message-info">
                <span>发布日期:</span>
                <span class="info-date">2015-09-12 01:15:12</span>
            </p>
            <div class="content-wrap">
                <p>请驾驶员注意，正常情况下：</p>
                <p>第一次领取驾驶证的有效期，是6年</p>
                <p>第二次换证后，驾驶证的有效期，是10年</p>
                <p>第三次换证后，才是长期使用的证件</p>
                <p>驾驶证扣分查询系统提醒广大驾驶员，要在驾驶证快到期钱的90天内，前往车管所换证</p>
                <p>而驾驶证超期后可能会出现下面三种状态：</p>
                <img src="/images/common/qrcode.png">
                <p>请驾驶员注意，正常情况下：</p>
                <p>第一次领取驾驶证的有效期，是6年</p>
                <p>第二次换证后，驾驶证的有效期，是10年</p>
                <p>第三次换证后，才是长期使用的证件</p>
                <p>驾驶证扣分查询系统提醒广大驾驶员，要在驾驶证快到期钱的90天内，前往车管所换证</p>
                <p>而驾驶证超期后可能会出现下面三种状态：</p>
            </div>
        </div>
    </div>
</div>
@stop