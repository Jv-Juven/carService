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

	<ul class="header-menu clearfix">
		<li class="header-menu-item nav-item">
			<a href="/serve-center/search/pages/violation">服务中心</a>
			<div class="item-underline"></div>
		</li>
		@if( Sentry::check())
		<li class="header-menu-item nav-item">
			@if ( Sentry::getUser()->is_business_user() )
			<a href="/finance-center/cost-manage/overview">财务中心</a>
			@else
			<a href="/finance-center/cost-manage/refund-record">财务中心</a>
			@endif
			<div class="item-underline"></div>
		</li>
		<li class="header-menu-item nav-item">
			<a href="/message-center/message/all">消息中心</a>
			<div class="item-underline"></div>
		</li>
		<li class="header-menu-item nav-item">
			@if ( Sentry::getUser()->is_business_user() )
			<a href="/account-center/account-info">账户设置</a>
			@else
			<a href="/account-center/account-info-c">账户设置</a>
			@endif
			<div class="item-underline"></div>
		</li>
		@endif
	</ul>

	<ul class="header-btns-wrapper">
		@if( Sentry::check())
		<li>
			<a class="bg-block header-user">
			<!-- <a class="bg-block header-user" href="/account-center/account-info"> -->
			<!-- <a class="bg-block header-user" href="//account-center/account-info-c"> -->
				<!-- <img src="/images/components/avatar.png"> -->
				<span class="header-name">
					{{Sentry::getUser()->login_account}}
				</span>
			</a>
		</li> 
		<li class="header-btns">
			<a id="logout_btn" href="javascript:">
				退出
			</a>
		</li>
		@else
		<li>
			<div class="log-reg-btns">
				<a class="reg-btn first" href="javascript:" id="header_regbtn">注册</a>
				<a class="reg-btn" href="javascript:" id="header_logbtn">登录</a>
				<ul class="reg-dropdown-list">
					<li class="reg-li first"><a href="javascript:">个人用户注册</a></li>
					<li class="reg-li"><a href="/user/b_register">企业用户注册</a></li>
				</ul>
			</div>
		</li>
		@endif
		<li class="header-btns btns-last">
			<a href="http://faq.gzcheshang.com">
				帮助中心
			</a>
		</li>
	</ul>
</div>