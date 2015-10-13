<nav id="admin-header" class="header navbar navbar-default">
	<div class="navbar-header">
      <a class="navbar-brand" href="/admin/business-center/new-user-list">
        <img src="/images/common/logo.png">
      </a>
    </div>

	<ul class="header-menu clearfix nav navbar-nav">
		<li class="header-menu-item">
			<a href="/admin/business-center/new-user-list">操作中心</a>
		</li>
		<li class="header-menu-item">
			<a href="/admin/service-center/consult">客服中心</a>
		</li>
		<li class="header-menu-item">
			<a href="javascript:void(0);">经营分析</a>
		</li>
		<li class="header-menu-item">
			<a href="/admin/account/change-password">账户设置</a>
		</li>
	</ul>

	@if(Auth::check())
	<div id="welcome">
		<span id="text">欢迎你，{{{ Auth::user()->username }}}</span>
		<a href="javascript:void(0);" id="logout">退出</a>
	</div>
	@endif
</nav>