<div class="left-nav" id="serve-left-nav">
	<div class="nav">
		<ul class="nav-first">
			<li class="li">
				<a href="javascript:">
					<i class="nav-icon">
						<img src="/images/components/data_icon.png">
					</i>
					数据查询
				</a>
				<ul class="nav-sec">
					<li>
						<a class="nav-item" href="/serve-center/search/pages/violation">
							<i>•</i>
							违章查询
						</a>
						<i class="nav-arrow">
							<img src="/images/components/nav_arrow.png">
						</i>
					</li>
					@if( Sentry::check() && Sentry::getUser()->is_business_user() )
					<li class="">
						<a class="nav-item" href="/serve-center/search/pages/license">
							<i>•</i>
							驾驶证查询
						</a>
						<i class="nav-arrow">
							<img src="/images/components/nav_arrow.png">
						</i>
					</li>
					<li>
						<a class="nav-item" href="/serve-center/search/pages/car">
							<i>•</i>
							车辆查询
						</a>
						<i class="nav-arrow">
							<img src="/images/components/nav_arrow.png">
						</i>
					</li>
					@else
					<li class="">
						<a class="nav-item">
						</a>
					</li>
					<li>
						<a class="nav-item">
						</a>
					</li>
					@endif
				</ul>
			</li>
			@if( Sentry::check() )
			<li class="li">
				<a href="javascript:">
					<i class="nav-icon">
						<img src="/images/components/business_icon.png">
					</i>
					业务办理
				</a>
				<ul class="nav-sec">
					<li>
						<a class="nav-item" href="/serve-center/agency/pages/search_violation">
							<i>•</i>
							违章办理
						</a>
						<i class="nav-arrow">
							<img src="/images/components/nav_arrow.png">
						</i>
					</li>
				</ul>
			</li>
			<li class="li">
				<a href="javascript:">
					<i class="nav-icon">
						<img src="/images/components/indent_icon.png">
					</i>
					订单管理
				</a>
				<ul class="nav-sec">
					<li>
						<a class="nav-item" href="/serve-center/order/pages/order_violation/">
							<i>•</i>
							违章代办
						</a>
						<i class="nav-arrow">
							<img src="/images/components/nav_arrow.png">
						</i>
					</li>
				</ul>
			</li>
			@endif
		</ul>
	</div>
</div>