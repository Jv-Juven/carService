@extends("layouts.submaster")


@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/common/mask/mask.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/account-center/account-info.css">
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
				<div class="tr tr-title">手机号码：</div>
													@if( Sentry::check())
				<div class="tr tr-content" id="phone_num">{{ Sentry::getUser()->login_account}}</div>
													@endif
				<a class="change-psd" href="javascript:">修改密码</a>
			</div>

		</div>
	</div>
	<div class="mask-bg"></div>		
	<div class="mask-wrapper change-password" style="display: none;">
		<div class="warn-box">
			<div class="warn-title">
				修改密码
				<span class="warn-close">×</span>
			</div>
			<div class="warn-content">
				<div class="warn-msg">
					<div class="msg-line">
						<span class="msg-title">
							手机证码：
						</span>
						<input class="msg-input psd-phone-code" type="text" placeholder="请前往注册邮箱获取验证码"/>
						<a href="javascript:" class="msg-btn psd-get-phone-codes">获取验证码</a>
					</div>
					<!-- <div class="msg-line">
						<span class="msg-title">
							原密码：
						</span>
						<input class="msg-input old-password" type="password" placeholder="请填写账号的原密码"/>
					</div> -->
					<div class="msg-line">
						<span class="msg-title">
							密码：
						</span>
						<input class="msg-input psd-password" type="password" placeholder="字母、数字或者英文符号，最短6位，区分大小写"/>
					</div>
					<div class="msg-line">
						<span class="msg-title">
							确认密码：
						</span>
						<input class="msg-input psd-repassword" type="password" placeholder="请再次输入密码"/>
					</div>
				</div>
				<div class="tips-words psd-tips"></div>
				<div class="account-btns">
					<a class="account-btn psd-save-btn" href="javascript:">保存</a>
					<a class="account-btn psd-cancel-btn" href="javascript:">取消</a>
				</div>
			</div>
		</div>
	</div>
@stop

@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/account-center/account-info-c.js"></script>
@stop