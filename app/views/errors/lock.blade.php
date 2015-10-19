@extends("layouts.login-master")

@section("title")
账号锁定
@stop

@section("css")
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/register-b/email-active.css">
<link rel="stylesheet" type="text/css" href="/dist/css/pages/account-status/write-codes.css">
@stop

@section("body")

<div class="body-content">
	
	<div class="content-container">
		<div class="email-tips write-codes-inputs no-pass-title">
			您的帐号异常，已被锁定！
		</div>
		<div class="tips-words warn-tips"></div>
		<div class="submit-btn write-codes-submit-btn">
			<!-- <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=3151392485&site=qq&menu=yes">联系客服</a> -->
			@include("components.contact-us-a")
		</div>
	</div>


</div>

@stop

@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/register-b/email-active.js"></script>
@stop
