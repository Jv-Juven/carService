@extends('layouts.submaster')

@section('title')
    费用管理 -- 概览
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/finance-center/cost-manage/overview.css">
@stop

@section('js')
@stop

@section('left-nav')
    @include('components.left-nav.finance-center-left-nav')
@stop

@section('right-content')
<div class="overview-wrap">
    <div class="overview-body">
        <div class="info-wrap">
            <div class="account-info">
                <span class="label">账户余额</span>
                <span class="balance">100</span>
                <span class="desc">账户余额仅可以抵扣数据查询费用</span>
                <button class="recharge-btn">充值</button>
            </div>
        </div>

        <div class="fee-type-wrap">
            <table class="fee-type-table">
                <tr class="fee-tb-tr">
                    <th class="fee-tb-it fee-tb-th">查询类型</th>
                    <th class="fee-tb-it fee-tb-th">交通违章</th>
                    <th class="fee-tb-it fee-tb-th">驾驶证</th>
                    <th class="fee-tb-it fee-tb-th">车辆</th>
                </tr>
                <tr class="fee-tb-tr">
                    <td class="fee-tb-it fee-tb-th">费用</td>
                    <td class="fee-tb-it fee-tb-ct">0.12</td>
                    <td class="fee-tb-it fee-tb-ct">0.5</td>
                    <td class="fee-tb-it fee-tb-ct">0.5</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@stop