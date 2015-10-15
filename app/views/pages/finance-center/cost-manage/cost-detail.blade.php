@extends('layouts.submaster')


@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/lib/css/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="/dist/css/pages/finance-center/cost-manage/cost-detail.css">
@stop

@section('js')
@parent
<script type="text/javascript" src="/lib/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/dist/js/pages/finance-center/cost-manage/cost-detail.js"></script>
@stop

@section('left-nav')
    @include('components.left-nav.finance-center-left-nav')
@stop

@section('right-content')
<div class="cost-wrap">
    <div class="cost-body">
        <div class="query-wrap">
            <form method="GET" action="" class="query-form clearfix">
                <div class="query-item query-date">
                    <span class="query-label">请选择年月:</span>
                    <input name="date" type="text" class="query-ipt-dt date-start" id="date"
                        value="{{{ $previous_input['date'] }}}"
                    >
                </div>
                <div class="query-item query-type">
                    <span class="query-label">交易类型:</span>
                    <select name="cost_type" class="query-slt-ty">
                        @if ( $previous_input['cost_type'] == '10' )
                        <option value="10" selected>普通充值</option>
                        <option value="20">查询</option>
                        @else
                        <option value="10">普通充值</option>
                        <option value="20" selected>查询</option>
                        @endif
                    </select>
                </div>
                <input type="hidden" name="page" value="1">
                <input class="query-sbm" type="submit" value="查询">
            </form>
        </div>
        @if ( !empty( $results ) )
            
            <div class="data-wrap">
                <div class="data-section">
                    <table class="data-list">
                        @if( $previous_input['cost_type'] == '10' )
                            <tr class="data-item data-head">
                                <th class="item-key">流水号</th>
                                <th class="item-key">日期</th>
                                <th class="item-key">备注</th>
                                <th class="item-key">金额</th>
                            </tr>
                            @foreach( $results as $result )
                                <tr class="data-item odd-item">
                                    <td class="item-key">{{{ $result['cost_id'] }}}</td>
                                    <td class="item-key">{{{ $result['created_at'] }}}</td>
                                    <td class="item-key">普通充值</td>
                                    <td class="item-key">{{{ $result['number'] }}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="data-item data-head">
                                <th class="item-key">日期</th>
                                <th class="item-key">备注</th>
                                <th class="item-key">次数</th>
                            </tr>
                            @foreach( $results as $result )
                                <tr class="data-item odd-item">
                                    <td class="item-key">{{{ Carbon\Carbon::parse( $result['date'] )->toDateTimeString()  }}}</td>
                                    <td class="item-key">
                                        [消费]
                                        @if ( $result['type'] == 'violation' )
                                            违章查询
                                        @elseif ( $result['type'] == 'license' )
                                            驾驶证查询
                                        @elseif ( $result['type'] == 'car' )
                                            车辆查询
                                        @endif
                                    </td>
                                    <td class="item-key">{{{ $result['value'] }}}</td
                                    <td class="item-key"></td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

@stop