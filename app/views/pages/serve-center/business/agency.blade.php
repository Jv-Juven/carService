@extends("layouts.submaster")

@section("title")
违章查询
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
			@include("components.vio-process", array("num" => "1"))
			<!-- 办理进程 END	 -->

			<div class="agency-details"></div>
			<div class="agency-form">

				<table class="form-table">
					<tr class="agency-table-head">
						<td>
							以下信息很重要
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