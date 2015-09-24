@extends('layouts.submaster')

@section('title')
    费用管理 -- 退款记录
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/finance-center/cost-manage/refund-record.css">
@stop

@section('js')
@stop

@section('left-nav')
    @include('components.left-nav.finance-center-left-nav')
@stop

@section('right-content')
<div class="refund-wrap">
    <div class="data-wrap">
        <div class="data-section">
            <table class="data-list">
                <tr class="data-item data-head">
                    <th class="item-key">订单编号</th>
                    <th class="item-key">申请时间</th>
                    <th class="item-key">审批时间</th>
                    <th class="item-key">状态</th>
                    <th class="item-key">备注</th>
                </tr>
                <tr class="data-item odd-item">
                    <td class="item-key">45555521123333</td>
                    <td class="item-key">2015-09-21 23:44:03</td>
                    <td class="item-key">2015-09-21 23:44:03</td>
                    <td class="item-key">审批中</td>
                    <td class="item-key">订单已办理</td>
                </tr>
                <tr class="data-item even-item">
                    <td class="item-key">45555521123333</td>
                    <td class="item-key">2015-09-21 23:44:03</td>
                    <td class="item-key">2015-09-21 23:44:03</td>
                    <td class="item-key">审批中</td>
                    <td class="item-key">订单已办理</td>
                </tr>
                <tr class="data-item odd-item">
                    <td class="item-key">45555521123333</td>
                    <td class="item-key">2015-09-21 23:44:03</td>
                    <td class="item-key">2015-09-21 23:44:03</td>
                    <td class="item-key">审批中</td>
                    <td class="item-key">订单已办理</td>
                </tr>
            </table>
        </div>
        <div class="paginate-wrap clearfix">
            <div class="clk-rd-wrap">
                <ul class="page-list clearfix">
                    <li class="page-item"><</li>
                    <li class="page-item active">1</li>
                    <li class="page-item">2</li>
                    <li class="page-item">3</li>
                    <li class="page-item">4</li>
                    <li class="page-item">5</li>
                    <li class="page-item">></li>
                </ul>
            </div>
            <div class="ipt-rd-wrap">
                <form class="clearfix" method="GET" action="">
                    <input type="text" name="page" class="ipt-page">
                    <input type="submit" value="GO" class="ipt-sbm">
                </form>
            </div>
        </div>
    </div>
</div>
@stop