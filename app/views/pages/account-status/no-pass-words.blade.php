@extends("layouts.login-master")

@section("title")
账号审核
@stop

@section("css")
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/register-b/email-active.css">
<link rel="stylesheet" type="text/css" href="/dist/css/pages/account-status/write-codes.css">
@stop

@section("body")

<div class="body-content">
	
	<div class="content-container">
		<div class="no-pass-words">
			您的帐号正在审核中，请耐心等候！
		</div>
</div>

@stop

@section("js")
	@parent
@stop
