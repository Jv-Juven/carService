@extends("layouts.submaster")

@section("title")
违章代办
@stop

@section("css")
	@parent
	<!-- <link rel="stylesheet" type="text/css" href="/dist/css/common/mask/mask.css"> -->
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
						<td class="indent-table-title">订单编号：</td>
						<td class="indent-table-content">
							<input type="text" id="indent-number" placeholder="请输入发动机号码后6位"/>
						</td>
					</tr>
					<tr>
						<td class="indent-table-title">车牌号码：</td>
						<td class="indent-table-content">
							<select class="input select-plate">
								<option value="">粤</option>
								<option value="">琼</option>
								<option value="">桂</option>
								<option value="">黔</option>
							</select>
							<input class="input plate-num" type="text" placeholder="车牌号码后六位"/>
							<select class="input select-color">
								<option value="">蓝牌</option>
								<option value="">红牌</option>
								<option value="">黑牌</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="indent-table-title">车牌号码：</td>
						<td class="indent-table-content">
							<select class="input select-plate plate-status">
								<option value="">全部</option>
								<option value="">红牌</option>
								<option value="">黄牌</option>
							</select>
							业务状态：
							<select class="input select-plate plate-status">
								<option value="">全部</option>
								<option value="">红牌</option>
								<option value="">黄牌</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="indent-table-title">下单时间：</td>
						<td class="indent-table-content indent-date">
							<input class="input plate-num" type="date" placeholder=""/>
							至
							<input class="input plate-num" type="date" placeholder=""/>
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
					<tr class="table-line">
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
					<!-- 单位车辆信息表 办理中 START -->
					<tr class="info-head">
						<td colspan="6">
							<span class="plate">粤X12345</span>
							下单时间：
							<span class="date">2015-09-11</span>
							订单编号：
							<span>12345677654321</span>
						</td>
					</tr>
					<tr class="table-line">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="last-td" rowspan="3"><!-- 接受该项的信息条目数+1（即：总条目数是2，填3） -->
							已受理办理中
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
							<span class="deal-btn wait-pay">已付款</span>
							<a class="deal-btn atonce-pay" href="javascript:">申请退款</a>
						</td>
					</tr>
					<tr class="table-foot-blank"></tr>
					<!-- 单位车辆信息表 办理中 END -->
					<!-- 单位车辆信息表 已办理 START -->
					<tr class="info-head">
						<td colspan="6">
							<span class="plate">粤X12345</span>
							下单时间：
							<span class="date">2015-09-11</span>
							订单编号：
							<span>12345677654321</span>
						</td>
					</tr>
					<tr class="table-line">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="last-td" rowspan="3"><!-- 接受该项的信息条目数+1（即：总条目数是2，填3） -->
							已办理
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
							<span class="deal-btn wait-pay">已办理</span>
						</td>
					</tr>
					<tr class="table-foot-blank"></tr>
					<!-- 单位车辆信息表 已办理 END -->
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
@stop










