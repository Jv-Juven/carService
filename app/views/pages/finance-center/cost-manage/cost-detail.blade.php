@extends('layouts.submaster')

@section('title')
    费用管理 -- 费用明细
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/finance-center/cost-manage/cost-detail.css">
@stop

@section('js')
@stop

@section('left-nav')
    @include('components.left-nav.finance-center-left-nav')
@stop

@section('right-content')
<div class="cost-wrap">
    <div class="cost-body">
        <div class="query-wrap">
            <form action="" class="query-form clearfix">
                <div class="query-item query-date">
                    <span class="query-label">起止时间:</span>
                    <input name="" type="text" class="query-ipt-dt date-start">
                    <span class="query-label">至</span>
                    <input name="" type="text" class="query-ipt-dt date-end">
                </div>
                <div class="query-item query-type">
                    <span class="query-label">交易类型:</span>
                    <select name="type" id="" class="query-slt-ty">
                        <option value="">普通充值</option>
                        <option value="">消费</option>
                    </select>
                </div>
                <input class="query-sbm" typ="submit" value="查询">
            </form>
        </div>
        <div class="data-wrap">
            <div class="data-section">
                <table class="data-list">
                    <tr class="data-item data-head">
                        <th class="item-key item-no">流水号</th>
                        <th class="item-key item-date">日期</th>
                        <th class="item-key item-note">备注</th>
                        <th class="item-key item-money">金额</th>
                    </tr>
                    <tr class="data-item odd-item">
                        <td class="item-key item-no">455552112333</td>
                        <td class="item-key item-date">2015-09-11 23:24:03</td>
                        <td class="item-key item-note">[消费]违章查询</td>
                        <td class="item-key item-money">$ 50.00</td>
                    </tr>
                    <tr class="data-item even-item">
                        <td class="item-key item-no">455552112333</td>
                        <td class="item-key item-date">2015-09-11 23:24:03</td>
                        <td class="item-key item-note">[消费]违章查询</td>
                        <td class="item-key item-money">$ 50.00</td>
                    </tr>
                    <tr class="data-item odd-item">
                        <td class="item-key item-no">455552112333</td>
                        <td class="item-key item-date">2015-09-11 23:24:03</td>
                        <td class="item-key item-note">[消费]违章查询</td>
                        <td class="item-key item-money">$ 50.00</td>
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
</div>
@stop