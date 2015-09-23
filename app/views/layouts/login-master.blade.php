<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html, charset=utf8"/>
	<title>
		@yield("title", "登录")
	</title>
	@section("css")
	<link rel="stylesheet" type="text/css" href="/dist/css/components.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/login.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/common.css">
	@show
</head>
<body>
	<div class="login-wrapper">
		<div class="login-header">
			<div class="header-content">
				<img class="logo" src="/images/login/logo.png">
				<div class="header-items">
					<ul>
						<li class="blue-text login-btn">
							<a href="/">
								登录
							</a>
						</li>
						<li class="blue-text">
							<a href="/">
								注册
							</a>
						</li>
						<li class="login-help">
							<a href="/">
								使用帮助
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="login-body clearfix">
		@section("body")
		@show
		</div>
		<div class="login-footer">
			<div class="footer-words">
				<span>@版权归所有广州车尚信息科技有限公司</span>|
				<span>技术支持：广州紫睿网络有限科技公司</span>
			</div>
		</div>
	</div>
	@section("js")
	@show
</body>
</html>