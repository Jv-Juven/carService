@extends("layouts.submaster")

@section("title")
驾驶证查询
@stop

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/business/violation.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/data/drive.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/data/cars.css">
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
						<div class="input-title">身份证/驾驶证：</div>
						<div class="inputs">
							<input class="input fullwidth" type="text" placeholder="请输入您的身份证号或驾驶证号"/>
						</div>
					</div>
					<div class="input-wrapper">
						<div class="input-title">档案编号：</div>
						<div class="inputs">
							<input class="input fullwidth" type="text" placeholder="请输入您驾驶证上的档案编号"/>
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

			<div class="cars-results">
				本年度，截止至当前时间，您累计已扣分<span class="stress">3分</span>	！
			</div>
		</div>
	</div>
@stop