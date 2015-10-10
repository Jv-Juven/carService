@extends("layouts.login-master")

@section("title")
基本信息|注册
@stop

@section("css")
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/register-b/email-active.css">
@stop

@section("body")

<div class="body-content">
	
	@include("components.reg-process", array("num" => "2"))

	<div class="content-container">
		<div class="email-icon">
			<img src="/images/register-b/email_icon.png">
			激活服务平台账号
		</div>
		<div class="email-tips">
			感谢注册！确认邮件已发送至您的注册邮箱*********@**.com。请进入邮箱查看邮件，并激活公众平台账号。
		</div>
		<!-- <div class="submit-btn">
			<a target="_blank" href="/email-active">登录邮箱</a>
		</div> -->
		<div class="email-explain">
			<table>
				<tr>
					<td>没有收到邮件？</td>
				</tr>
				<tr>
					<td>1、请确认邮件地址是否正确，你可以返回<span>重新填写</span>。</td>
				</tr>
				<tr>
					<td>2、确认你的邮件垃圾箱。</td>
				</tr>
				<tr>
					<td>3、若仍未收到确认邮件，请尝试<span>重新发送</span>。</td>
				</tr>
			</table>
		</div>
	</div>

</div>

@stop
