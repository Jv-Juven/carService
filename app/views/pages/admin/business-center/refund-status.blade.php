@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－查看退款状态
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/refund-status.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="refund-status-content">
        <h4>退款状态</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label>订单号：</label>
                <span>{{{ $indent->order_id }}}</span>
            </div>
            <div class="form-group">
                <label>退款金额：</label>
                <span>{{ $indent->capital_sum + $indent->service_charge_sum + $indent->express_fee }}</span>
            </div>
            <div class="form-group">
                <label>退款状态：</label>
                <span>退款处理中</span>
            </div>
        </form>
    </div>
@stop

@section('js')
    @parent
@stop
    