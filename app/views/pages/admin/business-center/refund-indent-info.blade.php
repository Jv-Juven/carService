@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－申请退款订单详情
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/refund-indent-info.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="refund-indent-info-content">
        <h4>订单详情</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label>订单编号：</label>
                <span>{{{ $indent->order_id }}}</span>
            </div>
            <div class="form-group">
                <label>车牌号码：</label>
                <span>{{{ $indent->car_plate_no }}}</span>
            </div>
            <div class="form-group">
                <label>车辆类型：</label>
                <span>{{{ $indent->car_type_no }}}</span>
            </div>
            <div class="form-group">
                <label>应付总额：</label>
                <span>{{ $indent->capital_sum + $indent->service_charge_sum }} 元</span>
            </div>
            <div class="form-group">
                <label>凭证快递费用：</label>
                <span>{{{ $indent->express_fee }}} 元</span>
            </div>
        </form>

        <button id="submit-btn" type="button" class="btn btn-primary">退款审批</button>
    </div>
@stop

@section('js')
    @parent
@stop
    