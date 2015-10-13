<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html, charset=utf8"/>
	<title>
		登录
	</title>
	<link rel="stylesheet" type="text/css" href="/dist/css/common.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/components.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/login.css">
</head>
<body>
	<div class="login-wrapper">
		<!-- 页头部分 START -->
		<div class="login-header">
			<div class="header-content">
				<img class="logo" src="/images/login/logo.png">
				<div class="header-items">
					<ul>
						<li class="blue-text login-btn">
							<a href="/user/b_register">
								企业用户注册
							</a>
						</li>
						<li class="blue-text">
							<a href="javascript:" id="personalReg">
								个人用户注册
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
		<!-- 页头部分 END -->
		<div class="login-body clearfix">
			<div class="header-img">
				<img class="slider-img" src="/images/login/slider.png">
				<div class="login-box">
					<div class="login-content clearfix">
						<div class="login-content-title">
							<a href="javascript:" class="login-menu-btn active">企业用户登录</a>
							<a href="javascript:" class="login-menu-btn">个人用户登录</a>
						</div>
						<div class="input email-input">
							<input id="account_num" type="text" placeholder="邮箱"/>
						</div>
						<div class="input psd-input">
							<input id="password" type="password" placeholder="密码"/>
						</div>
						<div class="login-content-tips clearfix">
							<!-- <span class="tips01"><a href="/">立即注册</a></span> -->
							<span class="tips02"><a href="javascript:">忘记密码</a></span>
						</div>
						<div class="login-content-btn">
							<a class="bg-block" href="javascript:">
								登录
							</a>
						</div>
						<div class="tips-words login-tips"></div>
					</div>
				</div>
			</div>
			<div class="login-content">
				<dl class="notices-title clearfix">
					<dt>系统公告</dt>
					@foreach( $notices as $notice )
					<dd>
						<i>•</i>
						<a href="/message-center/message/detail?notice_id={{{ $notice->id }}}">
							{{{ $notice->title }}}
						</a>
						<i>
							<img class="new" src="/images/login/new_icon.png">
						</i>
					</dd>
					@endforeach
					<dd class="notices-more">
						<a href="{{{ $message_url }}}">查看更多 > </a>
					</dd>
				</dl>
				<div class="login-quick-check clearfix">
					<div class="wrapper-title quick-check-title">
						<i>•</i>
						<span class="title">快速查询</span>
					</div>
					<div class="quick-check-items">
						<a href="/serve-center/search/pages/violation">
							<dl>
								<dt>
									<img src="/images/login/icons01.png">
									违章查询
								</dt>
								<dd>
									提供交通违章实时查询服务
								</dd>
							</dl>
						</a>
						<a href="javascript:" class="click-no-jump">
							<dl>
								<dt>
									<img src="/images/login/icons01.png">
									驾驶证查询
								</dt>
								<dd>
									提与供驾驶证相关的数据查询服务
								</dd>
							</dl>
						</a>
						<a href="javascript:" class="click-no-jump">
							<dl>
								<dt>
									<img src="/images/login/icons01.png">
									车辆查询
								</dt>
								<dd>
									提供与机动车信息相关的数据查询服务
								</dd>
							</dl>
						</a>
						<div style="clear:both"></div>
					</div>
					<div class="login-cases clearfix">
						<div class="wrapper-title">
							<i>•</i>
							<span class="title">成功案例</span>
						</div>
						<ul class="cases-wrapper clearfix">
							<li class="case active">
								<div class="case-img">
									<img class="nocol-cover" src="/images/login/case01.png">
									<img class="col-cover" src="/images/login/case01_col.png">
								</div>
								<span class="case-title">
									政捷车务管家
								</span>
							</li>
						</ul>
						<div class="cases-big-imgs">
							<img style="display: block;" src="/images/login/big_img01.png">
							<img src="/images/login/big_img02.png">
							<img src="/images/login/big_img01.png">
							<img src="/images/login/big_img02.png">
							<img src="/images/login/big_img01.png">
							<img src="/images/login/big_img02.png">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="login-footer">
			<div class="footer-words">
				<span>版权所有@广州车尚信息科技有限公司</span>|
				<span>技术支持：广州紫睿科技有限公司</span>
			</div>
		</div>
	</div>
	<!-- 浮层 START -->
	
	@include("components.log-reg-mask")
	@include("components.warn-mask")
	<!-- 浮层 END -->

	<script type="text/javascript" src="/lib/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="/dist/js/components.js"></script>
	<script type="text/javascript" src="/dist/js/pages/login/login.js"></script>
</body>
</html>