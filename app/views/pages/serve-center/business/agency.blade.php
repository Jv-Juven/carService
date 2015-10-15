@extends("layouts.submaster")


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
							委托人：
						</td>
						<td  class="details-content">
							{{{ $agency_user_attr }}}
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							车牌号码：
						</td>
						<td class="details-content">
							<span id="plate_num">{{{ $agency_info['car_plate_no'] }}}</span>
							<span class="plate-col">{{{ Config::get( 'carType' )[ $agency_info[ 'car_type_no' ] ] }}}</span>
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							代理笔数：
						</td>
						<td class="details-content">
							<span id="agency_count">{{{ $agency_info['count'] }}}</span>笔
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							交通违章本金：
						</td>
						<td class="details-content">
							￥ {{{ $agency_info['total_fee'] }}} 元
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							服务费：
						</td>
						<td class="details-content">
							￥ <span id="charge">{{{ $agency_info['service_fee'] * $agency_info['count'] }}}</span> 元
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							是否需要违章票证：
						</td>
						<td class="details-content">
							<label for="noneed">
							<input type="radio" id="noneed" checked="true" name="need" />
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
							￥ <span id="express_fee">{{{ $agency_info['express_fee'] }}}</span> 元
						</td>
					</tr>
					<tr class="details-tr">
						<td class="details-title">
							费用总计：
						</td>
						<td class="details-content">
							￥ <span id="sum">{{{ $agency_info['service_fee'] * $agency_info['count'] + $agency_info['total_fee'] }}}</span> 元
						</td>
					</tr>
					<tr class="details-blank"></tr>
					<input type="hidden" id="count" value="{{{ $agency_info['count'] }}}">
					<input type="hidden" id="capital-sum" value="{{{ $agency_info['total_fee'] }}}">
					<input type="hidden" id="service-fee" value="{{{ $agency_info['service_fee'] }}}">
					<input type="hidden" id="express-fee" value="{{{ $agency_info['express_fee'] }}}">
				</table>
			</div>
			<div class="agency-form">

				<table class="form-table" border="0" cellspacing="0" cellpadding="0">
					<tr class="agency-table-head">
						<td colspan="2">
							若需快递回单，以下信息很重要, 请准确填写
						</td>
					</tr>
					<tr class="table-blank"></tr>
					<tr class="table-content">
						<td class="content-title">收件人姓名：</td>
						<td class="content-input">
							<input type="text" id="name" placeholder="请输入接受违章办理票证的收件人姓名"/>
						</td>
					</tr>

					<tr class="table-content">
						<td class="content-title">收件人手机：</td>
						<td class="content-input">
							<input type="text" id="phone" placeholder="用于接受办理进度短信或紧急联系"/>
						</td>
					</tr>
					<tr class="table-content">
						<td class="content-title">收件地址：</td>
						<td class="content-input">
							<input type="text" id="address" placeholder="签收违章办理凭证的地址"/>
						</td>
					</tr>
					<!-- <tr class="table-content">
						<td class="content-title">发动机号后4位：</td>
						<td class="content-input">
							<input type="text" id="engine_number" placeholder="用于快速缴纳罚款"/>
						</td>
					</tr> -->
					<tr class="agency-form-tips">
						<td colspan="2">
							<span class="tips-title">温馨提示：</span>为确保您能及时收到违章代办后的相关凭证，请务必留下手机号码及收取凭证的详细地址。
						</td>
					</tr>
				</table>

			</div>
			<!-- 提交按钮 START -->
			<div class="tips-words agency-warn-tips"></div>
			<div class="agency-btn-wrapper">
				<div class="submit-btn agency-btn">
					<a href="javascript:">提交订单</a>
				</div>
				<div class="submit-btn agency-btn-cancel">
					<a href="javascript:">取消办理</a>
				</div>
			</div>
			
			<!-- 提交按钮 END -->

			<input id="sign" type="hidden" value="{{{ $sign }}}"/>

		</div>
	</div>
@stop

@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/serve-center/agency.js"></script>
@stop