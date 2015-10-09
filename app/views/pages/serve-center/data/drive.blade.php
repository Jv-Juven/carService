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
							@include("components.province-abbre")
							<input class="input plate-num" type="text" placeholder="车牌号码后六位"/>
							@include("components.select-types")
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

			@include("components.violation-info")

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
@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/serve-center/drive.js"></script>
@stop


