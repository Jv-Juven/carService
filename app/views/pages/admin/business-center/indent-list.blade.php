@extends('pages.admin.business-center.layout')

@section('title')
    操作中心－违章代办
@stop

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/indent-list.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="indent-list-content">
        <ul class="nav nav-pills" id="admin-business-center-indent-list-header">
            <li class="nav active">
                <a href="/admin/business-center/indent-list?type=all" id="all">全部</a>
            </li>
            <li class="nav">
                <a href="/admin/business-center/indent-list?type=untreated" id="untreated">未受理</a>
            </li>
            <li class="nav">
                <a href="/admin/business-center/indent-list?type=treated" id="treated">已受理</a>
            </li>
            <li class="nav">
                <a href="/admin/business-center/indent-list?type=treating" id="treating">办理中</a>
            </li>
            <li class="nav">
                <a href="/admin/business-center/indent-list?type=finished" id="finished">已完成</a>
            </li>
            <li class="nav">
                <a href="/admin/business-center/indent-list?type=closed" id="closed">已关闭</a>
            </li>
            <div class="clear"></div>
        </ul>
    
        <table id="indent-list" class="table table-bordered table-hover">
        	<tr>
        		<th>违章时间</th>
        		<th>违章地点</th>
        		<th>违章行为</th>
                <th>细项/元</th>
        		<th>金额/元</th>
        		<th>交易状态</th>
        	</tr>
            @foreach($indents as $indent)
        	<tr class="info">
        		<td>{{{ $indent->car_plate_no }}}</td>
        		<td colspan="2">订单编号：{{{ $indent->order_id }}}</td>
        		<td colspan="2">下单时间：{{{ $indent->created_at }}}</td>
        		@if($indent->process_status == "0")
        		<td>处理状态：未受理</td>
        		@elseif($indent->process_status == "1")
        		<td>处理状态：已受理</td>
        		@elseif($indent->process_status == "2")
        		<td>处理状态：办理中</td>
        		@elseif($indent->process_status == "3")
        		<td>处理状态：已完成</td>
        		@elseif($indent->process_status == "4")
        		<td>处理状态：已关闭</td>
        		@endif
        	</tr>
	        	@foreach($indent->traffic_violation_info as $traffic_violation_info)
	        	<tr>
	        		<td>{{{ $traffic_violation_info->rep_event_time }}}</td>
	        		<td>{{{ $traffic_violation_info->rep_event_addr }}}</td>
	        		<td>{{{ $traffic_violation_info->rep_violation_behavior }}}</td>
	        		<td>
	        			本金：{{{ $traffic_violation_info->rep_priciple_balance }}} <br />
	        			服务费：{{{ $traffic_violation_info->rep_service_charge }}}
	        		</td>
	        		<td>{{ $traffic_violation_info->rep_priciple_balance + $traffic_violation_info->rep_service_charge }}</td>
	        		@if($indent->traffic_violation_info[0]->traffic_id == $traffic_violation_info->traffic_id)
		        		@if($indent->trade_status == "0")
		        			<td rowspan="{{ count($indent->traffic_violation_info) }}">等待付款</td>
		        		@elseif($indent->trade_status == "1")
		        			<td rowspan="{{ count($indent->traffic_violation_info) }}">已付款</td>
		        		@elseif($indent->trade_status == "2")
		        			<td rowspan="{{ count($indent->traffic_violation_info) }}">申请退款</td>
		        		@elseif($indent->trade_status == "3")
		        			<td rowspan="{{ count($indent->traffic_violation_info) }}">已退款</td>
		        		@elseif($indent->trade_status == "4")
		        			<td rowspan="{{ count($indent->traffic_violation_info) }}">退款失败</td>
		        		@endif
		        	@endif
	        	</tr>
	        	@endforeach
            @endforeach
		</table>
		<nav>
            @if ($count < $totalCount)
                {{ $indents->links() }}
            @endif
        </nav>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/indent-list.js"></script>
@stop
    