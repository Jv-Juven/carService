@extends("layouts.login-master")

@section("title")
填写打款验证码
@stop

@section("css")
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/register-b/email-active.css">
<link rel="stylesheet" type="text/css" href="/dist/css/pages/account-status/write-codes.css">
@stop

@section("body")

<div class="body-content">
	
	<div class="content-container">
		<div class="email-tips write-codes-inputs">
			<input type="text" class="write-codes-input" placeholder="请输入打款备注码" />
		</div>
		<div class="write-codes-tips">
			请于贵公司/单位的财务沟通，获得打款验证码
		</div>
		<div class="tips-words warn-tips"></div>
		<div class="submit-btn write-codes-submit-btn">
			<a href="javascript:">提交验证</a>
		</div>

</div>

@stop

@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/account-status/write-codes.js"></script>
@stop
