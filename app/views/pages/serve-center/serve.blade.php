@extends("layouts.submaster")

@section("title")
服务中心
@stop

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/serve.css">
@stop

@section("left-nav")
@include("components.left-nav.serve-left-nav")
@stop

@section("right-content")
	<div class="right-content">
		<div class="content-box">
			<a href="/">
				<dl>
					<dt>
						<img src="/images/serve/serve_icon01.png">
						违章查询
					</dt>
					<dd>
						凭有效的检测合格报告，在市公安交通管理局车辆管理所，以及台山、新会、恩平、开平
					</dd>
				</dl>
			</a>
			<a href="/">
				<dl>
					<dt>
						<img src="/images/serve/serve_icon02.png">
						驾驶证查询
					</dt>
					<dd>
						凭有效的检测合格报告，在市公安交通管理局车辆管理所，以及台山、新会、恩平、开平
					</dd>
				</dl>
			</a><a href="/">
				<dl>
					<dt>
						<img src="/images/serve/serve_icon03.png">
						车辆查询
					</dt>
					<dd>
						凭有效的检测合格报告，在市公安交通管理局车辆管理所，以及台山、新会、恩平、开平
					</dd>
				</dl>
			</a>
		</div>
	</div>
@stop