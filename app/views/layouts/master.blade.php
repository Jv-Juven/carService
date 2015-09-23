<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>
		@yield("title", "车尚车服务系统")
	</title>
	@section("css")
	<link rel="stylesheet" type="text/css" href="/dist/css/common.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/components.css">
	@show
</head>
<body>
<div id="wrapper">
	@include("components.header")
	@section("body")

	@show
	<div class="mask"></div>		
	<div id="mask">
		<div class="warn-box">
			<div class="warn-title">
				提示
				<span class="warn-close">×</span>
			</div>
			<div class="warn-content">
				<span class="warn-msg">
					请选中要办理的违章记录！
				</span>
			</div>
		</div>
	</div>		
	@section("js")
	@show
</div>

</body>
</html>