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
			<!-- 办理进程 START  -->
			@include("components.vio-process", array("num" => "1"))
			<!-- 办理进程 END	 -->

			<!-- 查询框 START -->
			<div class="violation-search">
				<div class="violation-wrapper">
					<div class="input-wrapper">
						<div class="input-title">车牌号码：</div>
						<div class="inputs">
							<select class="input select-plate">
								<option value="">粤</option>
								<option value="">琼</option>
								<option value="">桂</option>
								<option value="">黔</option>
							</select>
							<input class="input plate-num" type="text" placeholder="车牌号码后六位"/>
							<select class="input select-color">
								<option value="01">大型汽车</option>
								<option value="02">小型汽车</option>
								<option value="03">使馆汽车</option>
								<option value="04">领馆汽车</option>
								<option value="05">境外汽车</option>
								<option value="06">外籍汽车</option>
								<option value="07">普通摩托车</option>
								<option value="08">轻便摩托车</option>
								<option value="09">使馆摩托车</option>
								<option value="10">领馆摩托车</option>
								<option value="11">境外摩托车</option>
								<option value="12">外籍摩托车</option>
								<option value="13">低速车</option>
								<option value="14">拖拉机</option>
								<option value="15">挂车</option>
								<option value="16">教练车</option>
								<option value="17">教练摩托车</option>
								<option value="18">试验汽车</option>
								<option value="19">试验摩托车</option>
								<option value="20">临时入境汽车</option>
								<option value="21">临时入境摩托车</option>
								<option value="22">临时行驶车</option>
								<option value="23">警用汽车</option>
								<option value="24">警用摩托</option>
								<option value="25">原农机号牌车</option>
								<option value="26">香港入出境车</option>
								<option value="27">澳门入出境车</option>
								<option value="31">武警号牌</option>
								<option value="32">军队号牌</option>
								<option value="99">其他号牌</option>
							</select>
						</div>
					</div>
					<div class="input-wrapper">
						<div class="input-title">发动机号码：</div>
						<div class="inputs">
							<input class="input fullwidth" type="text" placeholder="请输入发动机号码后六位"/>
						</div>
					</div>

					<div class="input-wrapper">
						<div class="input-title">车架号码：</div>
						<div class="inputs">
							<input class="input fullwidth" type="text" placeholder="请输入车架号码后六位"/>
						</div>
					</div>
					<div class="input-wrapper input-btn">
						确定
					</div>
				</div>
			</div>
			<!-- 查询框 END -->

			<div class="violation-info">
				<div class="info-tr">
					<div class="info-title">账户余额</div>
					<div class="info-num">100</div>
				</div>
				<div class="info-tr">
					<div class="info-title">剩余查询次数</div>
					<div class="info-num">2000</div>
				</div>
			</div>

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
@stop