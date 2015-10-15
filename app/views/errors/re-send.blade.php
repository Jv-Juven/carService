@extends("layouts.login-master")

@section("title")
链接失效
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
			该链接已失效
		</div>
</div>

@stop

@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/register-b/email-active.js"></script>
@stop