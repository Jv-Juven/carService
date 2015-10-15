<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html, charset=utf8"/>
	<title>
		@yield("title", "车尚 ｜ 实时精准的数据查询平台－交通违章－驾驶证－机动车")
	</title>
	@section("css")
	<link rel="stylesheet" type="text/css" href="/dist/css/components.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/login.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/common.css">
	@show
</head>
<body>

	<!-- 页头 START		 -->
	@include("components.reg-header")
	<!-- 页头 END		 -->

	<div class="login-wrapper">
		<div class="login-body clearfix">
		@section("body")
		@show
		</div>
	</div>
	
	<div class="login-footer">
		<div class="footer-words">
			<span>版权所有@广州车尚信息科技有限公司</span>|
			<span>技术支持：广州紫睿科技有限公司</span>
		</div>
	</div>
	@section("js")
		<script type="text/javascript" src="/lib/js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="/dist/js/components.js"></script>
	@show
</body>
</html>