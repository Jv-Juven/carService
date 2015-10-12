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
            <input type="hidden" id="indent-id" value="{{{ $indent->order_id }}}">
            <div class="form-group">
                <label>退款单号：</label>
                <span>{{{ $indent->order_id }}}</span>
            </div>
            <div class="form-group">
                <label>总笔数：</label>
                <span>{{{ $indent->agency_no }}}</span>
            </div>
            <div class="form-group">
                <label>总金额：</label>
                <span>{{ $indent->capital_sum + $indent->service_charge_sum + $indent->express_fee}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">退款金额：</label>
                <span>{{ $indent->capital_sum + $indent->service_charge_sum + $indent->express_fee}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">审批结果：</label>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="approve-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span id="dropdown-show">同意</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="approve-dropdown">
                        <li><a class="dropdown-select" data-name="1" href="javascript:void(0);">同意</a></li>
                        <li><a class="dropdown-select" data-name="3" href="javascript:void(0);">拒绝</a></li>
                    </ul>
                </div>
            </div>
            <button id="submit-btn" type="button" class="btn btn-primary">提交</button>
        </form>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/approve-refund-application.js"></script>
@stop
    