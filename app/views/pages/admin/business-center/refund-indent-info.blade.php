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
                <span>{{{ $indent->car_type }}}</span>
            </div>
            <div class="form-group">
                <label>应付总额：</label>
                <span>{{ $indent->capital_sum + $indent->service_charge_sum }} 元</span>
            </div>
            <div class="form-group">
                <label>凭证快递费用：</label>
                <span>{{{ $indent->express_fee }}} 元</span>
            </div>
            <div class="form-group">
                <label>处理状态：</label>
                @if($indent->process_status == 0)
                <span>未受理</span>
                @elseif($indent->process_status == 1)
                <span>已受理</span>
                @elseif($indent->process_status == 2)
                <span>办理中</span>
                @elseif($indent->process_status == 3)
                <span>已完成</span>
                @else
                <span>已关闭</span>
                @endif
            </div>
            <div class="form-group">
                <label>交易状态：</label>
                @if($indent->trade_status == 0)
                <span>等待付款</span>
                @elseif($indent->trade_status == 1)
                <span>已付款</span>
                @elseif($indent->trade_status == 2)
                <span>申请退款</span>
                @else
                <span>已退款</span>
                @endif
            </div>
        </form>

        <hr />

        <table id="user-list" class="table table-striped table-bordered table-hover">
            <tr>
                <th>违章时间</th>
                <th>违章地点</th>
                <th>违章行为</th>
                <th>扣分分值</th>
                <th>本金</th>
                <th>服务费</th>
            </tr>
            @foreach($indent->traffic_violation_info as $info)
            <tr>
                <td>{{{ $info->rep_event_time }}}</td>
                <td>{{{ $info->rep_event_addr }}}</td>
                <td>{{{ $info->rep_violation_behavior }}}</td>
                <td>{{{ $info->rep_point_no }}}</td>
                <td>{{{ $info->rep_priciple_balance }}}</td>
                <td>{{{ $info->rep_service_charge }}}</td>
            </tr>
            @endforeach
        </table>

        <!-- 订单处理状态为<已受理>且交易状态为<申请退款>时才显示退款审批按钮 -->
        @if($indent->process_status == 1 && $indent->trade_status == 2)
        <a href="/admin/business-center/approve-refund-application?indent_id={{{ $indent->order_id }}}" target="_blank">
            <button id="submit-btn" type="button" class="btn btn-primary">退款审批</button>
        </a>
        @endif
    </div>
@stop

@section('js')
    @parent
@stop
    