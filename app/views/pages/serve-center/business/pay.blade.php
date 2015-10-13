@extends("layouts.submaster")

@section("title")
支付
@stop

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/business/pay.css">
@stop

@section("left-nav")
	@include("components.left-nav.serve-left-nav")
@stop

@section("right-content")
	<div class="content-box">
		<div class="content-container">
			<!-- 办理进程 START  -->
			@include("components.vio-process", array("num" => "3"))
			<!-- 办理进程 END	 -->

			<div class="pay-tips">
				<span>订单提交成功，请您尽快付款！订单号： <span id="order_id">{{{ $order->order_id }}}</span> </span>
				<span>请您在提交订单后24小时之内完成支付，否则订单会自动取消。</span>
			</div>

			<div class="pay-table-wrapper">
				<table class="pay-table" border="0" cellpadding="0" cellspacing="0">
					<tr class="pay-table-head">
						<th colspan="2">
							订单信息
						</th>
					</tr>
					<tr class="table-blank"></tr>
					<tr class="pay-table-tr">
						<td class="tr-title">车牌号码：</td>
						<td class="tr-content">
							{{{ $order->car_plate_no }}} <span class="plate-col">{{{ Config::get( 'carType' )[ $order->car_type_no ] }}}</span>
						</td>
					</tr>
					@if ( $order->is_delivered )
					<tr class="pay-table-tr">
						<td class="tr-title">收件人姓名：</td>
						<td class="tr-content">
							{{{ $order->recipient_name }}}
						</td>
					</tr>
					<tr class="pay-table-tr">
						<td class="tr-title">收件人手机号码：</td>
						<td class="tr-content">
							{{{ $order->recipient_phone }}}
						</td>
					</tr>
					<tr class="pay-table-tr">
						<td class="tr-title">收件人地址：</td>
						<td class="tr-content">
							{{{ $order->recipient_addr }}}
						</td>
					</tr>
					@endif
					<tr class="pay-table-tr">
						<td class="tr-title">费用总计：</td>
						<td class="tr-content">
							{{{ $order->service_charge_sum + $order->capital_sum + (int)$order->express_fee }}}
						</td>
					</tr>
					<tr class="pay-table-tr">
						<td class="tr-title">费用明细：</td>
						<td class="tr-content">
							<table class="pay-details">
								<tr>
									<td>办理笔数</td>
									<td>违章罚款本金</td>
									<td>违章滞纳金</td>
									<td>代办服务费用</td>
									<td>票证邮寄费用</td>
								</tr>
								<tr>
									<td>{{{ $order->agency_no }}}</td>
									<td>{{{ $order->capital_sum }}}</td>
									<td>{{{ $order->late_fee_sum  }}}</td>
									<td>{{{ $order->service_charge_sum }}}</td>
									<td>{{{ (int)$order->express_fee }}}</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr class="table-blank"></tr>
				</table>
			</div>
			<div class="pay-btns">
				<div class="btn">
					<a target="_blank" href="javascript:" id="pay_wechat">
						<img src="/images/serve/wechat.png">
						<span class="btn-name">
							微信支付
						</span>
					</a>
				</div>
				<div class="btn" style="margin-left: 30px;">
					<a target="_blank" href="javascript:" id="pay_paypal">
						<img src="/images/serve/zhifubao.png">
						<span class="btn-name">
							支付宝支付
						</span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="order-id" value="{{{ $order->order_id }}}">
@stop

@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/serve-center/pay.js"></script>
@stop



