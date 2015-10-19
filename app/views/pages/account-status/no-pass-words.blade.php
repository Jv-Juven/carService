@extends("layouts.login-master")


@section("css")
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/register-b/email-active.css">
<link rel="stylesheet" type="text/css" href="/dist/css/pages/account-status/write-codes.css">
<link rel="stylesheet" type="text/css" href="/dist/css/pages/account-status/no-pass-words.css">
@stop

@section("body")

<div class="body-content">
	
	<div class="content-container">
		<div class="no-pass-words">
			您的帐号正在审核中，请耐心等候！
		</div>
		<div class="no-pass-words-tips">
			如有疑问，请发送到邮箱 <span class="no-pass-email">service@gzcheshang.com</span>
		</div>
	</div>
</div>

@stop

@section("js")
	@parent
@stop
