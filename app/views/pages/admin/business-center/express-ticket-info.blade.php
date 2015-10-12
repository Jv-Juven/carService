@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－查看退款状态
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/express-ticket-info.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="express-ticket-info-content">
        <h4>办理凭证快递信息</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label>订单编号：</label>
                <span>{{{ $indent->order_id }}}</span>
            </div>
            <div class="form-group">
                <label>收件人姓名：</label>
                <span>{{{ $indent->recipient_name }}}</span>
            </div>
            <div class="form-group">
                <label>收件人手机：</label>
                <span>{{{ $indent->recipient_phone }}}</span>
            </div>
            <div class="form-group">
                <label>收件人地址：</label>
                <span>{{{ $indent->recipient_addr }}}</span>
            </div>
        </form>
    </div>
@stop

@section('js')
    @parent
@stop
    