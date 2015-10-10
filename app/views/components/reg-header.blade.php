<div class="header">
	<div class="logo">
		<a href="/">
			<ul class="logo-wrapper">
				<li>
					<span class="bg-block">
						<img src="/images/common/logo.png">
					</span>
				</li>
			</ul>
		</a>
	</div>

	<ul class="header-btns-wrapper">
		@if( Sentry::check() )
		<li>
			<a class="bg-block header-user" href="/">
				<!-- <img src="/images/components/avatar.png"> -->
				<span class="header-name">
					{{Sentry::getUser()->login_account}}
				</span>
			</a>
		</li>
		<li class="header-btns">
			<a href="/">
				退出
			</a>
		</li>
		@else
		<li>
			<div class="log-reg-btns">
				<a class="reg-btn first" href="javascript:" id="header_regbtn">注册</a>
				<a class="reg-btn" href="javascript:">登录</a>
				<ul class="reg-dropdown-list">
					<li class="reg-li first"><a href="javascript:">个人用户注册</a></li>
					<li class="reg-li"><a href="/">企业用户注册</a></li>
				</ul>
			</div>
		</li>
		<li class="header-btns btns-last">
			<a href="/">
				帮助中心
			</a>
		</li>
		@endif
	</ul>
</div>