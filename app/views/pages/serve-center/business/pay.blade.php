@extends("layouts.submaster")

@section("title")
违章办理
@stop

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/business/agency.css">
@stop

@section("left-nav")
	@include("components.left-nav.serve-left-nav")
@stop

@section("right-content")
	<div class="content-box">
		<div class="content-container">
			<!-- 办理进程 START  -->
			@include("components.vio-process", array("num" => "2"))
			<!-- 办理进程 END	 -->

			<div class="agency-details">
				<table class="details-table" border="0" cellpadding="0" cellspacing="0">
					<tr class="details-head">
						<th colspan="2" class="">
							违章代办缴纳
						</th>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							代办机构：
						</td>
						<td class="details-content">
							[公司名]联系人姓名
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							车牌号码：
						</td>
						<td class="details-content">
							粤X1234 <span class="plate-col">蓝牌</span>
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							代理笔数：
						</td>
						<td class="details-content">
							2笔
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							交通违章本金：
						</td>
						<td class="details-content">
							￥ 400.0 元
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							服务费：
						</td>
						<td class="details-content">
							￥ 20.0 元
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							是否需要违章票证：
						</td>
						<td class="details-content">
							<label for="noneed">
							<input type="radio" id="noneed" name="need" />
								不需要
							</label>
							<label for="express">
							<input type="radio" id="express" name="need" />
								快递回单
							</label>
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							票证快递费：
						</td>
						<td class="details-content">
							￥ 0 元
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							费用总计：
						</td>
						<td class="details-content">
							￥ 420.0 元
						</td>
					</tr>
					<tr class="details-blank"></tr>

				</table>
			</div>
			<div class="agency-form">

				<table class="form-table" border="0" cellspacing="0" cellpadding="0">
					<tr class="agency-table-head">
						<td colspan="2">
							以下信息很重要,请准确填写
						</td>
					</tr>
					<tr class="table-blank"></tr>
					<tr class="table-content">
						<td class="content-title">收件人姓名：</td>
						<td class="content-input">
							<input type="text" placeholder="请输入接受违章办理票证的收件人姓名"/>
						</td>
					</tr>

					<tr class="table-content">
						<td class="content-title">收件人姓名：</td>
						<td class="content-input">
							<input type="text" placeholder="请输入接受违章办理票证的收件人姓名"/>
						</td>
					</tr>
					<tr class="table-content">
						<td class="content-title">收件人姓名：</td>
						<td class="content-input">
							<input type="text" placeholder="请输入接受违章办理票证的收件人姓名"/>
						</td>
					</tr>
					<tr class="table-content">
						<td class="content-title">收件人姓名：</td>
						<td class="content-input">
							<input type="text" placeholder="请输入接受违章办理票证的收件人姓名"/>
						</td>
					</tr>
					<tr class="agency-form-tips">
						<td colspan="2">
							<span class="tips-title">温馨提示：</span>为确保您能及时收到违章代办后的相关凭证，请务必留下手机号码及收取凭证的详细地址。
						</td>
					</tr>
				</table>

			</div>
			<!-- 提交按钮 START -->
			<div class="submit-btn">
				<a href="javascript:">提交订单</a>
			</div>
			<!-- 提交按钮 END -->
		</div>
	</div>
@stop