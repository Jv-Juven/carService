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
					<tr class="indent-number"></tr>
					<tr class="indent-number"></tr>
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
							<!-- <select class="input select-plate plate-status indent-city">
								<option value="">全部</option>
								<option value="">广州市</option>
								<option value="">深圳市</option>
								<option value="">珠海市</option>
								<option value="">汕头市</option>
								<option value="">韶关市</option>
								<option value="">佛山市</option>
								<option value="">江门市</option>
								<option value="">湛江市</option>
								<option value="">茂名市</option>
								<option value="">肇庆市</option>
								<option value="">惠州市</option>
								<option value="">梅州市</option>
								<option value="">汕尾市</option>
								<option value="">河源市</option>
								<option value="">阳江市</option>
								<option value="">清远市</option>
								<option value="">东莞市</option>
								<option value="">中山市</option>
								<option value="">潮州市</option>
								<option value="">揭阳市</option>
								<option value="">云浮市</option>
							</select> -->
							
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
				<a class="inline-btn" href="javascript:">查询</a>
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
					<!-- 单位车辆信息表 未受理 START -->
					<tr class="info-head">
						<td colspan="6">
							<span class="plate">粤X12345</span>
							下单时间：
							<span class="date">2015-09-11</span>
							订单编号：
							<span>12345677654321</span>
						</td>
					</tr>
					<tr class="table-line" id="deal_status01">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="last-td" rowspan="3"><!-- 接受该项的信息条目数+1（即：总条目数是2，填3） -->
							未受理
						</td>
					</tr>

					<tr class="indent-tr-content">
						<td>
							<span>2015-08-15</span>
							<span>11:52:00</span>
						</td>
						<td>
							<span>[广东省广州市]</span>
							<span>广州大学城贝岗街</span>
							<span>[电子眼未处理未交款]</span>
						</td>
						<td class="vio-behaviour">
							机动车违反规定停放、临时停车，妨碍其他车辆、行人通行的
							<span>[1039]</span>
						</td>
						<td class="money">
							<span>本金：200.0</span>
							<span>滞纳金：0</span>
							<span>服务费：20.0</span>
						</td>

						<td>
							<span>210</span>
						</td>
					</tr>
					<tr class="indent-tr-content">
						<td>
							<span>2015-08-15</span>
							<span>11:52:00</span>
						</td>
						<td>
							<span>[广东省广州市]</span>
							<span>广州大学城贝岗街</span>
							<span>[电子眼未处理未交款]</span>
						</td>
						<td class="vio-behaviour">
							机动车违反规定停放、临时停车，妨碍其他车辆、行人通行的
							<span>[1039]</span>
						</td>
						<td class="money">
							<span>本金：200.0</span>
							<span>滞纳金：0</span>
							<span>服务费：20.0</span>
						</td>

						<td>
							<span>210</span>
						</td>
					</tr>
					<tr class="indent-deal">
						<td colspan="2">
							<span class="title">应付总额：</span>
							<span class="money">￥435.0元</span>
							<span class="express-fee">快递费：15.0元</span>
						</td>
						<td class="indent-deal-opration" colspan="4">
							<span class="deal-btn wait-pay">等待付款</span>
							<a class="deal-btn cancel-deal" href="javascript:">取消订单</a>
							<a class="deal-btn atonce-pay" href="javascript:">立即付款</a>
						</td>
					</tr>
					<tr class="table-foot-blank"></tr>
					<!-- 单位车辆信息表 未受理 END -->
				</table>
			</div>
			@include('components.pagination')
		</div>
	</div>
	<div class="mask-bg"></div>
	<div class="mask-wrapper">
		<div class="warn-box">
			<div class="warn-title">
				取消订单
				<div class="warn-close">×</div>
			</div>
			<div class="warn-content">
				<div class="warn-msg">
					<span class="content">确定取消订单？</span>
					<div class="btns">
						<a class="btn" href="javascript:">确定</a>
						<a class="btn" href="javascript:">取消</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mask-wrapper">
		<div class="warn-box">
			<div class="warn-title">
				申请退款
				<div class="warn-close">×</div>
			</div>
			<div class="warn-content">
				<div class="warn-msg">
					<span class="content">我们已收到您的退款申请，请等待工作人员审批！</span>
					<div class="btns">
						<a class="btn" href="javascript:">确定</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/template" id="indent_template">
		<tr class="info-head">
			<td colspan="6">
				<span class="plate">粤X12345</span>
				下单时间：
				<span class="date">2015-09-11</span>
				订单编号：
				<span>12345677654321</span>
			</td>
		</tr>
		<tr class="table-line" id="deal_status01">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td class="last-td" rowspan="3"><!-- 接受该项的信息条目数+1（即：总条目数是2，填3） -->
				未受理
			</td>
		</tr>

		<tr class="indent-tr-content">
			<td>
				<span>2015-08-15</span>
				<span>11:52:00</span>
			</td>
			<td>
				<span>[广东省广州市]</span>
				<span>广州大学城贝岗街</span>
				<span>[电子眼未处理未交款]</span>
			</td>
			<td class="vio-behaviour">
				机动车违反规定停放、临时停车，妨碍其他车辆、行人通行的
				<span>[1039]</span>
			</td>
			<td class="money">
				<span>本金：200.0</span>
				<span>滞纳金：0</span>
				<span>服务费：20.0</span>
			</td>

			<td>
				<span>210</span>
			</td>
		</tr>
		<tr class="indent-tr-content">
			<td>
				<span>2015-08-15</span>
				<span>11:52:00</span>
			</td>
			<td>
				<span>[广东省广州市]</span>
				<span>广州大学城贝岗街</span>
				<span>[电子眼未处理未交款]</span>
			</td>
			<td class="vio-behaviour">
				机动车违反规定停放、临时停车，妨碍其他车辆、行人通行的
				<span>[1039]</span>
			</td>
			<td class="money">
				<span>本金：200.0</span>
				<span>滞纳金：0</span>
				<span>服务费：20.0</span>
			</td>

			<td>
				<span>210</span>
			</td>
		</tr>
		<tr class="indent-deal">
			<td colspan="2">
				<span class="title">应付总额：</span>
				<span class="money">￥435.0元</span>
				<span class="express-fee">快递费：15.0元</span>
			</td>
			<td class="indent-deal-opration" colspan="4">
				<span class="deal-btn wait-pay">等待付款</span>
				<a class="deal-btn cancel-deal" href="javascript:">取消订单</a>
				<a class="deal-btn atonce-pay" href="javascript:">立即付款</a>
			</td>
		</tr>
		<tr class="table-foot-blank"></tr>
	</script>
	@section("js")
		@parent
		<script type="text/javascript" src="/lib/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="/dist/js/pages/serve-center/indent-agency.js"></script>
	@stop
@stop










