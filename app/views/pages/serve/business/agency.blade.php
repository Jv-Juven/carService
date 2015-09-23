@extends("layouts.submaster")

@section("title")
违章查询
@stop

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve/business/violation.css">
@stop

@section("right-content")
	<div class="right-content">
	@include("components.left-nav.violation-left-nav")
		<div class="content-box">
			
		</div>
	</div>
@stop