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
                <span>12354242653768484795689876</span>
            </div>
            <div class="form-group">
                <label>收件人姓名：</label>
                <span>黄生</span>
            </div>
            <div class="form-group">
                <label>收件人手机：</label>
                <span>18911111111</span>
            </div>
            <div class="form-group">
                <label>收件人地址：</label>
                <span>广东省广州市大学城外环西路100号</span>
            </div>
            <div class="form-group">
                <label>发动机后4位：</label>
                <span>Q123</span>
            </div>
        </form>
    </div>
@stop

@section('js')
    @parent
@stop
    