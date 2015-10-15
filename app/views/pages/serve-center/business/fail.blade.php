@extends("layouts.submaster")

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/business/success.css">
@stop

@section("left-nav")
	@include("components.left-nav.serve-left-nav")
@stop

@section("right-content")
	<div class="content-box">
		<div class="content-container">
			<!-- 办理进程 START  -->
			@include("components.vio-process", array("num" => "4"))
			<!-- 办理进程 END	 -->

			<div class="success-tips">
				<div class="tips-num">
					<span class="title">订单编号：</span>
					<span class="num">45521521443</span>
				</div>
				<div class="tips-bill">
					<span class="title">已付金额：</span>
					<span class="num">￥50.00</span>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div class="success-content">
				<div class="success-icon">
					<img src="/images/serve/fail_icon.png">
				</div>
				<div class="success-msg">
					您的订单未能支付成功，请重新支付！错误代码：91101
				</div>
				<div class="submit-btn">
					<a href="javascript:">重新支付</a>
				</div>
			</div>

		</div>
	</div>
@stop