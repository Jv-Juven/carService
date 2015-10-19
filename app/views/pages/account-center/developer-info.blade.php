@extends("layouts.submaster")

@section("title")

@stop

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/account-center/developer-info.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/common/mask/mask.css">
@stop

@section("left-nav")
	@include("components.left-nav.account-center-left-nav")
@stop

@section("right-content")
	<div class="content-box">
		<div class="content-container">
			
			<div class="title">
				注册信息
			</div>
			<div class="developer-tr">
				<div class="tr tr-title">APP KEY：</div>
				<div class="tr tr-content company-name">*****************************</div>
			</div>

			<div class="developer-tr">
				<div class="tr tr-title">APP SECRET：</div>
				<div class="tr tr-content reg-license">****************************************</div>
			</div>
			<div class="submit-btn">
				<a href="javascript:">
					完整显示
				</a>
			</div>
		</div>
	</div>
	<div class="mask-bg"></div>		
	<div class="mask-wrapper">
		<div class="warn-box">
			<div class="warn-title">
				显示密码
				<span class="warn-close">×</span>
			</div>
			<div class="warn-content">
				<div class="warn-msg">
					<div class="msg-line">
						<span class="msg-title">
							邮箱验证码：
						</span>
						<input class="msg-input codes-input" id="developer_get_codes" type="text" placeholder="请前往注册邮箱获取验证码"/>
						<a href="javascript:" class="msg-btn get-codes-btn">获取验证码</a>
					</div>
				</div>
				<span class="tips-words dev-tips"></span>
				<div class="submit-btn msg-submit-btn">
					<a href="javascript:">提交</a>
				</div>
			</div>
		</div>
	</div>
@stop
@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/account-center/developer-info.js"></script>
@stop







