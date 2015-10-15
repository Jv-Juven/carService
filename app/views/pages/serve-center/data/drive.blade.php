@extends("layouts.submaster")

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/business/violation.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/data/cars.css">
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
						<div class="input-title">身份证/驾驶证：</div>
						<div class="inputs">
							<input class="input fullwidth" id="driver_license" type="text" placeholder="请输入您的身份证号或驾驶证号"/>
						</div>
					</div>
					<div class="input-wrapper">
						<div class="input-title">档案编号：</div>
						<div class="inputs">
							<input class="input fullwidth" id="file_codes" type="text" placeholder="请输入您驾驶证上的档案编号"/>
						</div>
					</div>
					<div class="tips-words drive-tips"></div>
					<div class="input-wrapper input-btn drive-btn">
						查询
					</div>
				</div>
			</div>
			<!-- 查询框 END -->

			@include("components.violation-info", [ 'account', $account ])
			
			<div style="clear: both;"></div>
			<div class="drive-results clearfix">
				本年度，截止至当前时间，您累计已扣分<span class="stress">3分</span>！
			</div>
		</div>
	</div>
@stop


@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/serve-center/drive.js"></script>
@stop



