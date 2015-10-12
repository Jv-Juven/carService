<div class="left-nav" id="account-center-left-nav">
	<div class="nav">
		<ul class="nav-first">
			@if(Sentry::getUser()->user_type == 1)
			<li class="li">
				<a href="javascript:">
					<i class="nav-icon">
						<img src="/images/components/setting_icon.png">
					</i>
					账号设置
				</a>
				<ul class="nav-sec">
					<li>
						<a class="nav-item" href="/account-center/account-info">
							<i>•</i>
							账号信息
						</a>
						<i class="nav-arrow">
							<img src="/images/components/nav_arrow.png">
						</i>
					</li>
				</ul>
			</li>
			@endif
			<li class="li">
				<a href="javascript:">
					<i class="nav-icon">
						<img src="/images/components/user_icon.png">
					</i>
					开发者中心
				</a>
				<ul class="nav-sec">
					<li>
						@if(Sentry::getUser()->user_type == 1)
						<a class="nav-item" href="/account-center/developer-info">
						@else
						<a class="nav-item" href="/account-center/account-info-c">
						@endif
							<i>•</i>
							开发者信息
						</a>
						<i class="nav-arrow">
							<img src="/images/components/nav_arrow.png">
						</i>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>