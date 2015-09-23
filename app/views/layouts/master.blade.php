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

	<div class="body-content">
		@section("body")
		@show
		<div style="clear: both;"></div>
	</div>	
	@section("js")
	@show
</div>

</body>
</html>