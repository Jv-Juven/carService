<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>
		@yield("title", "车尚车服务系统－后台管理系统")
	</title>
	@section("css")
	<link rel="stylesheet" type="text/css" href="/lib/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/lib/css/bootstrap/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/admin-components.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/layout.css">
	@show
</head>
<body>
<div id="wrapper">
	@include("components.admin.header")

	<div class="body-content">
		@section("body")

		@show
	</div>	
	@section("js")
	<script type="text/javascript" src="/lib/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="/lib/js/bootstrap/bootstrap.min.js"></script>
	@show
</div>

</body>
</html>