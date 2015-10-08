@extends("layouts.submaster")

@section("title")
违章查询
@stop

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/business/violation.css">
@stop

@section("left-nav")
@include("components.left-nav.serve-left-nav")
@stop

@section("right-content")
	<div class="content-box">
		<div class="violation-container">
			<!-- 查询框 START -->
			<div class="violation-search">
				<div class="violation-wrapper">
					<div class="input-wrapper">
						<div class="input-title">车牌号码：</div>
						<div class="inputs">
							@include("components.province-abbre")
							<input class="input plate-num" type="text" placeholder="车牌号码后六位"/>
							@include("components.select-types")
						</div>
					</div>
					<div class="input-wrapper">
						<div class="input-title">发动机号码：</div>
						<div class="inputs">
							<input class="input fullwidth" type="text" placeholder="请输入发动机号码后六位"/>
						</div>
					</div>

					<!-- <div class="input-wrapper">
						<div class="input-title">车架号码：</div>
						<div class="inputs">
							<input class="input fullwidth" type="text" placeholder="请输入车架号码后六位"/>
						</div>
					</div> -->
					<div class="input-wrapper input-btn">
						确定
					</div>
				</div>
			</div>
			<!-- 查询框 END -->

			@include("components.violation-info")

			<div class="violation-records">
				<div class="vio-records-title">
					车牌号码为<span class="records-plate">XXXXXX</span>的车辆共有<span class="records-total">3</span>笔违章记录
				</div>
				<div class="vio-records-table">
					<table>
						<tr class="tb-head">
							<th>
								<label for="vio_select_all">
									<input type="checkbox" id="vio_select_all"/>
									全选
								</label>
							</th>
							<th>违章时间</th>
							<th>[违章城市]违章地点</th>
							<th>违章行为</th>
							<th>扣分分值</th>
							<th>本金</th>
							<th>滞纳金</th>
							<th>服务费</th>
						</tr>
						<tr class="tb-tr">
							<td>
								<input type="checkbox" />
							</td>
							<td>
								<span class="date">2015-09-12</span>
								<span class="time">12:00</span>
							</td>
							<td>
								<span class="city">[广东省 广州市]</span>
								<span class="block">天河区五山街</span>
								<span class="status">[电子眼未处理-未交款]</span>
							</td>
							<td>
								<span class="describe">
									机动车违反规定停放、临时停车，妨碍其他车辆、行人通行的
								</span>
								<span class="num">[1006]</span>
							</td>
							<td>
								<span class="scores">0</span>
							</td>
							<td>
								<span class="principal">200</span>
							</td>
							<td>
								<span class="overdul-fine">0</span>
							</td>
							<td>
								<span class="serve-money">10</span>
							</td>
						</tr>
						<tr class="tb-tr">
							<td>
								<input type="checkbox" />
							</td>
							<td>
								<span class="date">2015-09-12</span>
								<span class="time">12:00</span>
							</td>
							<td>
								<span class="city">[广东省 广州市]</span>
								<span class="block">天河区五山街</span>
								<span class="status">[电子眼未处理-未交款]</span>
							</td>
							<td>
								<span class="describe">
									机动车违反规定停放、临时停车，妨碍其他车辆、行人通行的
								</span>
								<span class="num">[1006]</span>
							</td>
							<td>
								<span class="scores">0</span>
							</td>
							<td>
								<span class="principal">200</span>
							</td>
							<td>
								<span class="overdul-fine">0</span>
							</td>
							<td>
								<span class="serve-money">10</span>
							</td>
						</tr>
						<tr class="tb-tr">
							<td>
								<input type="checkbox" />
							</td>
							<td>
								<span class="date">2015-09-12</span>
								<span class="time">12:00</span>
							</td>
							<td>
								<span class="city">[广东省 广州市]</span>
								<span class="block">天河区五山街</span>
								<span class="status">[电子眼未处理-未交款]</span>
							</td>
							<td>
								<span class="describe">
									机动车违反规定停放、临时停车，妨碍其他车辆、行人通行的
								</span>
								<span class="num">[1006]</span>
							</td>
							<td>
								<span class="scores">0</span>
							</td>
							<td>
								<span class="principal">200</span>
							</td>
							<td>
								<span class="overdul-fine">0</span>
							</td>
							<td>
								<span class="serve-money">10</span>
							</td>
						</tr>
					</table>
					<div class="vio-submit-btn">
						<a href="javascript:">办理违章</a>
					</div>
				</div>
				<div class="vio-records-table">
					<table>
						<tr class="tb-head">
							<th>
								<label for="vio_select_all">
									<input type="checkbox" id="vio_select_all"/>
									全选
								</label>
							</th>
							<th>违章时间</th>
							<th>[违章城市]违章地点</th>
							<th>违章行为</th>
							<th>扣分分值</th>
							<th>本金</th>
							<th>滞纳金</th>
							<th>服务费</th>
						</tr>
						<tr class="tb-tr">
							<td>
								<input type="checkbox" />
							</td>
							<td>
								<span class="date">2015-09-12</span>
								<span class="time">12:00</span>
							</td>
							<td>
								<span class="city">[广东省 广州市]</span>
								<span class="block">天河区五山街</span>
								<span class="status">[电子眼未处理-未交款]</span>
							</td>
							<td>
								<span class="describe">
									机动车违反规定停放、临时停车，妨碍其他车辆、行人通行的
								</span>
								<span class="num">[1006]</span>
							</td>
							<td>
								<span class="scores">2</span>
							</td>
							<td>
								<span class="principal">200</span>
							</td>
							<td>
								<span class="overdul-fine">0</span>
							</td>
							<td>
								<span class="serve-money">10</span>
							</td>
						</tr>
						<tr class="tb-tr">
							<td>
								<input type="checkbox" />
							</td>
							<td>
								<span class="date">2015-09-12</span>
								<span class="time">12:00</span>
							</td>
							<td>
								<span class="city">[广东省 广州市]</span>
								<span class="block">天河区五山街</span>
								<span class="status">[电子眼未处理-未交款]</span>
							</td>
							<td>
								<span class="describe">
									机动车违反规定停放、临时停车，妨碍其他车辆、行人通行的
								</span>
								<span class="num">[1006]</span>
							</td>
							<td>
								<span class="scores">1</span>
							</td>
							<td>
								<span class="principal">200</span>
							</td>
							<td>
								<span class="overdul-fine">0</span>
							</td>
							<td>
								<span class="serve-money">10</span>
							</td>
						</tr>
						<tr class="tb-tr">
							<td>
								<input type="checkbox" />
							</td>
							<td>
								<span class="date">2015-09-12</span>
								<span class="time">12:00</span>
							</td>
							<td>
								<span class="city">[广东省 广州市]</span>
								<span class="block">天河区五山街</span>
								<span class="status">[电子眼未处理-未交款]</span>
							</td>
							<td>
								<span class="describe">
									机动车违反规定停放、临时停车，妨碍其他车辆、行人通行的
								</span>
								<span class="num">[1006]</span>
							</td>
							<td>
								<span class="scores">3</span>
							</td>
							<td>
								<span class="principal">200</span>
							</td>
							<td>
								<span class="overdul-fine">0</span>
							</td>
							<td>
								<span class="serve-money">10</span>
							</td>
						</tr>
					</table>
					<div class="vio-submit-btn">
						<a href="javascript:">联系客服</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 浮层 START -->
	@include("components.warn-mask")
	<!-- 浮层 END -->
@stop

@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/serve-center/violation.js"></script>
@stop