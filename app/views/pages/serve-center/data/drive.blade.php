@extends("layouts.submaster")

@section("title")
驾驶证查询
@stop

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/business/violation.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/data/drive.css">
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
						</div>
					</div>
					<div class="input-wrapper">
						<div class="input-title">档案编号：</div>
						<div class="inputs">
							<input class="input fullwidth" type="text" placeholder="请输入发动机号码后六位"/>
						</div>
					</div>

					<div class="input-wrapper input-btn">
						查询
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
					车牌号码为<span class="records-plate">XXXXXX</span>的机动车信息如下
				</div>
				<div class="vio-records-table">
					<table>
						<tr class="tb-head">
							<th>车辆类型</th>
							<th>状态</th>
							<th>检验合格状态</th>
							<th>强制报废日期</th>
						</tr>
						<tr class="tb-tr">
							<td>
								<span class="scores">小型汽车</span>
							</td>
							<td>
								<span class="principal">正常</span>
							</td>
							<td>
								<span class="overdul-fine">20120512</span>
							</td>
							<td>
								<span class="serve-money">20220512</span>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop