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
                @for ( $i = 0; $i < count( $records ); ++$i )
                <tr class="data-item odd-item">
                    <td class="item-key">{{{ $records->refund_id }}}</td>
                    <td class="item-key">{{{ $records->created_at->formate('Y-m-d H:i:s') }}}</td>
                    <td class="item-key">{{{ $records->approval_at }}}</td>
                    <td class="item-key">{{{ RefundRecord::format_audit_status( $records->status ) }}}</td>
                    <td class="item-key">{{{ $records->comment }}}</td>
                </tr>
                @endfor
            </table>
        </div>
        @include('components.pagination')
    </div>
</div>
@stop