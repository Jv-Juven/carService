@extends('layouts.submaster')

@section('title')
    费用管理 -- 费用明细
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/lib/css/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="/dist/css/pages/finance-center/cost-manage/cost-detail.css">
@stop

@section('js')
@parent
<script type="text/javascript" src="/lib/js/jquery-1.11.1.min.js"></script>
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
                    <span class="query-label">起止时间:</span>
                    <input name="date_start" type="text" class="query-ipt-dt date-start" id="date-start"
                        value="{{{ $previous_input['date_start'] }}}"
                    >
                    <span class="query-label">至</span>
                    <input name="date_end" type="text" class="query-ipt-dt date-end" id="date-end"
                        value="{{{ $previous_input['date_end'] }}}"
                    >
                </div>
                <div class="query-item query-type">
                    <span class="query-label">交易类型:</span>
                    <select name="cost_type" class="query-slt-ty">
                        @foreach ( $cost_types as $key => $value )
                            <option value="{{{ $key }}}"
                            @if ( $previous_input['cost_type'] == $key )
                                selected
                            @endif >
                            {{{ $value }}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="page" value="1">
                <input class="query-sbm" type="submit" value="查询">
            </form>
        </div>
        @if ( !empty( $paginator ) )
        <div class="data-wrap">
            <div class="data-section">
                <table class="data-list">
                    <tr class="data-item data-head">
                        <th class="item-key">流水号</th>
                        <th class="item-key">日期</th>
                        <th class="item-key">备注</th>
                        <th class="item-key">金额</th>
                    </tr>
                    @foreach( $paginator->getCollection() as $result )
                        <tr class="data-item odd-item">
                            <td class="item-key">{{{ $result['cost_id'] }}}</td>
                            <td class="item-key">{{{ $result['created_at']->format( 'Y-m-d H:i:s' ) }}}</td>
                            <td class="item-key">[{{{ $fee_types[ $result['fee_type_id'] ]['category'] }}}]{{{ $fee_types[ $result['fee_type_id'] ]['item'] }}}</td>
                            <td class="item-key">{{{ $result['number'] }}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @include('components.pagination', [
                'paginator' => $paginator,
                'params'    => $previous_input
            ])
        </div>
        @endif
    </div>
</div>

@stop