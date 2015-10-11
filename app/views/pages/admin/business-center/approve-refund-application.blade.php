@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－退款申请审批
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/approve-refund-application.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="approve-refund-application-content">
        <h4>退款申请审批</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label>退款单号：</label>
                <span>45555211233345555</span>
            </div>
            <div class="form-group">
                <label>审批时间：</label>
                <span>2015-10-07 13:05:36</span>
            </div>
            <div class="form-group">
                <label>总笔数：</label>
                <span>1</span>
            </div>
            <div class="form-group">
                <label>微信订单号：</label>
                <span>455afdafa123342526626</span>
            </div>
            <div class="form-group">
                <label>总金额：</label>
                <span>435</span>
            </div>
            <div class="form-group">
                <label for="company-name">退款金额：</label>
                <input type="text" id="refund-fee" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="company-name">审批结果：</label>
                <input type="text" id="refund-fee" class="form-control"/>
            </div>
        </form>
    </div>
@stop

@section('js')
    @parent
@stop
    