@extends("layouts.submaster")

@section("title")
违章代办
@stop

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/lib/css/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/indent/indent-agency.css">
@stop

@section("left-nav")
	@include("components.left-nav.serve-left-nav")
@stop

@section("right-content")
	<div class="content-box">
		<div class="content-container">
			<div class="indent-inputs-wrapper">
				<table class="input-table">
					<tr>
						<td colspan="2" class="btns-wrapper">
							<a class="btn active" href="javascript:">按订单编号查询</a>
							<a class="btn" href="javascript:">按订单信息查询</a>
						</td>
					</tr>
					<tr class="indent-number">
						<td class="indent-table-title">订单编号：</td>
						<td class="indent-table-content">
							<input type="text" id="indent-number" placeholder="请输入发动机号码后6位"/>
						</td>
					</tr>
					<tr class="indent-details">
						<td class="indent-table-title">车牌号码：</td>
						<td class="indent-table-content indent-inputs">
							@include("components.province-abbre")
							<input class="input plate-num" type="text" placeholder="车牌号码后六位"/>
							<!-- @include("components.select-types") -->
						</td>
					</tr>
					<tr class="indent-details">
						<td class="indent-table-title">业务状态：</td>
						<td class="indent-table-content">
							<select class="input select-plate plate-status indent-status">
								<option value="">全部</option>
								<option value="0">未受理</option>
								<option value="1">已受理</option>
								<option value="2">已受理办理中</option>
								<option value="3">订单完成</option>
								<option value="4">订单关闭</option>
							</select>
						</td>
					</tr>
					<tr class="indent-details">
						<td class="indent-table-title">下单时间：</td>
						<td class="indent-table-content indent-date">
							<input class="input plate-num" type="text" id="indent_date_start" placeholder=""/>
							至
							<input class="input plate-num" type="text" id="indent_date_end" placeholder=""/>
						</td>
					</tr>
				</table>
			</div>
			<div class="indent-btn">
				<a class="inline-btn indent-submit" href="javascript:">查询</a>
				<span class="indent-btn-tips">温馨提示：如果没有选择时间范围，默认查询1年以内的记录。</span>
			</div>
			<div class="indent-tables-wrapper">
				
				<table class="indent-list-table">

					<tr class="table-head">
						<th>违章时间</th>
						<th>违章地点</th>
						<th>违章行为</th>
						<th>细项/元</th>
						<th>总额/元</th>
						<th>处理状态</th>
					</tr>
					<tr class="table-blank"></tr>
					@foreach( $paginator->getCollection() as $order )
					<!-- 单位车辆信息表 未受理 START -->
					<tr class="indent-tr info-head">
						<td colspan="6">
							<span class="plate">{{{ $order->car_plate_no }}}</span>
							下单时间：
							<span class="date">{{{ $order->created_at }}}</span>
							订单编号：
							<span>{{{ $order->order_id }}}</span>
						</td>
					</tr>
					<tr class="indent-tr table-line" id="deal_status01">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="last-td" rowspan="{{{ $order->agency_no + 1 }}}"><!-- 接受该项的信息条目数+1（即：总条目数是2，填3） -->
							{{{ $order_status['process_status'][ $order->process_status ] }}}
						</td>
					</tr>

					@foreach ( $order->traffic_violation_info as $vinfo )
					<tr class="indent-tr indent-tr-content">
						<td>
							<span>{{{ $vinfo->rep_event_time }}}</span>
						</td>
						<td>
							<span>{{{ $vinfo->rep_event_addr }}}</span>
						</td>
						<td class="vio-behaviour">
							<span>{{{ $vinfo->rep_violation_behavior }}}</span>
						</td>
						<td class="money">
							<span>本金：{{{ $vinfo->rep_priciple_balance }}}</span>
							<span>滞纳金：{{{ $vinfo->rep_late_fee }}}</span>
							<span>服务费：{{{ $vinfo->rep_service_charge }}}</span>
						</td>

						<td>
							<span{{{ $vinfo->rep_priciple_balance + $vinfo->rep_late_fee + $vinfo->rep_service_charge }}}</span>
						</td>
					</tr>
					@endforeach

					<tr class="indent-tr indent-deal">
						<td colspan="2">
							<span class="title">应付总额：</span>
							<span class="money">￥{{{ $order->capital_sum + $order->service_charge_sum + $order->express_fee }}}元</span>
							<span class="express-fee">快递费：{{{ $order->express_fee }}}元</span>
						</td>
						<td class="indent-deal-opration" colspan="4">
							<span class="deal-btn wait-pay">{{{ $order_status['trade_status'][ $order->trade_status ] }}}</span>

							@if ( $order->trade_status == '0' && $order->trade_status == '0' )
							<a class="deal-btn cancel-deal" data-num="{{{ $order->order_id }}}" href="javascript:">取消订单</a>
							<a class="deal-btn atonce-pay immediately-pay" data-num="{{{ $order->order_id }}}" href="javascript:">立即付款</a>
							@elseif( $order->trade_status == '1' && $order->trade_status == '1' )

							<a class="deal-btn atonce-pay refund-btn" data-num="{{{ $order->order_id }}}" href="javascript:">申请退款</a>
							@endif
						</td>
					</tr>
					<tr class="indent-tr table-foot-blank"></tr>
					@endforeach
					<!-- 单位车辆信息表 未受理 END -->
				</table>
				
			</div>
			@include('components.pagination', [ 'paginator' => $paginator ])
		</div>
	</div>
	<div class="mask-bg"></div>
	<div class="mask-wrapper cancel-mask">
		<div class="warn-box">
			<div class="warn-title">
				取消订单
				<div class="warn-close">×</div>
			</div>
			<div class="warn-content">
				<div class="warn-msg">
					<span class="content">确定取消订单？</span>
					<div class="btns">
						<a class="btn sure-btn" data-num="" href="javascript:">确定</a>
						<a class="btn cancel-btn" href="javascript:">取消</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mask-wrapper refund-mask">
		<div class="warn-box">
			<div class="warn-title">
				申请退款
				<div class="warn-close">×</div>
			</div>
			<div class="warn-content">
				<div class="warn-msg">
					<span class="content">我们已收到您的退款申请，请等待工作人员审批！</span>
					<div class="btns">
						<a class="btn" id="refund_btn" href="javascript:">确定</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/template" id="indent_template">
	<% for (var i = 0; i < array.length; i ++){ 
		var rightTd = array[i]["traffic_violation_info"].length + 1;
		var info = array[i]["traffic_violation_info"]; 
		var total_sum = array[i]["capital_sum"] + parseInt(array[i]["express_fee"] + 0) + array[i]["service_charge_sum"]
		var process_status = "",
			trade_status = "";
		if (array[i]["process_status"] == 0){
			process_status = "未受理";
		}
		else if (array[i]["process_status"] == 1){
			process_status = "已受理";
		}
		else if (array[i]["process_status"] == 2){
			process_status = "已受理办理中";
		}
		else if (array[i]["process_status"] == 3){
			process_status = "订单完成";
		}
		else{
			process_status = "订单关闭";
		}

		if (array[i]["trade_status"] == 0){
			trade_status = "等待付款";
		}
		else if (array[i]["trade_status"] == 1){
			trade_status = "已付款";
		}
		else if (array[i]["trade_status"] == 2){
			trade_status = "申请退款";
		}
		else if (array[i]["trade_status"] == 3){
			trade_status = "已退款";
		}
		else{
			trade_status = "退款失败";
		}
		%>
		<tr class="indent-tr info-head">
			<td colspan="6">
				<span class="plate"><%- array[i]["car_plate_no"] %></span>
				下单时间：
				<span class="date"><%- array[i]["created_at"] %></span>
				订单编号：
				<span><%- array[i]["order_id"] %></span>
			</td>
		</tr>
		<tr class="indent-tr table-line">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td class="last-td" rowspan="<%- rightTd %>">
				<%- process_status %>
			</td>
		</tr>

		<% for(var j = 0; j < info.length; j ++ ){ %>
			<tr class="indent-tr indent-tr-content">
				<td class="table-time">
					<span><%- info[j]["rep_event_time"] %></span>
				</td>
				<td>
					<span><%- info[j]["rep_event_addr"] %></span>
				</td>
				<td class="vio-behaviour">
					<%- info[j]["rep_violation_behavior"] %>
					<span>[1039]</span>
				</td>
				<td class="money">
					<span>本金：<%- info[j]["rep_priciple_balance"] %></span>
					<span>滞纳金：<%- info[j]["rep_late_fee"] %></span>
					<span>服务费：<%- info[j]["rep_service_charge"] %></span>
				</td>

				<td>
					<span><%- info[j]["rep_total_fee"] %></span>
				</td>
			</tr>
		<% } %>
		<tr class="indent-tr indent-deal">
			<td colspan="2">
				<span class="title">应付总额：</span>
				<span class="money">￥<%- total_sum %>元</span>
				<% if (array[i]["express_fee"] !== null){ %>
					<span class="express-fee">快递费：<%- array[i]["express_fee"] %>元</span>
				<% } %>
			</td>
			<td class="indent-deal-opration" colspan="4">
				<span class="deal-btn wait-pay"><%- trade_status %></span>
				<% if (array[i]["process_status"] == 0 && array[i]["trade_status"] == 0){ %>
					<a class="deal-btn cancel-deal" data-num="<%- array[i]['order_id'] %>" href="javascript:">取消订单</a>
					<a class="deal-btn atonce-pay immediately-pay" data-num="<%- array[i]['order_id'] %>" href="javascript:">立即付款</a>
				<% } %>
				<% if (array[i]["process_status"] == 1 && array[i]["trade_status"] == 1){ %>
					<a class="deal-btn atonce-pay refund-btn" data-num="<%- array[i]['order_id'] %>" href="javascript:">申请退款</a>
				<% } %>
			</td>
		</tr>
		<tr class="indent-tr table-foot-blank"></tr>
		<% } %>
	</script>
	@section("js")
		@parent
		<script type="text/javascript" src="/lib/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="/lib/js/lodash.min.js"></script>
		<script type="text/javascript" src="/dist/js/pages/serve-center/indent-agency.js"></script>
	@stop
@stop










