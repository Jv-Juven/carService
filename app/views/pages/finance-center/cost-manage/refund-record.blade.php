@extends('layouts.submaster')


@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/finance-center/cost-manage/refund-record.css">
@stop

@section('js')
@parent
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
                    <th class="item-key">流水号</th>
                    <th class="item-key">日期</th>
                    <th class="item-key">审批时间</th>
                    <th class="item-key">审批状态</th>
                    <th class="item-key">备注</th>
                </tr>
                @for ( $i = 0; $i < count( $records ); ++$i )
                <tr class="data-item 
                    {{{ $i % 2 ? 'odd-item' : 'even-item' }}} {{-- 注意，这里$i是从0开始的哦 --}}
                ">
                    <td class="item-key">{{{ $records[$i]->refund_id }}}</td>
                    <td class="item-key">{{{ $records[$i]->created_at }}}</td>
                    <td class="item-key">{{{ $records[$i]->approval_at }}}</td>
                    <td class="item-key">{{{ RefundRecord::format_audit_status( $records[$i]->status ) }}}</td>
                    <td class="item-key">{{{ $records[$i]->comment }}}</td>
                </tr>
                @endfor
            </table>
        </div>
        @include('components.pagination', [
            'paginator' => $paginator
        ])
    </div>
</div>
@stop