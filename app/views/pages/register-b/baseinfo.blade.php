@extends("layouts.login-master")

@section("title")
基本信息|注册
@stop

@section("css")
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/register-b/baseinfo.css">
@stop

@section("body")

<div class="body-content">
	
	@include("components.reg-process", array("num" => "1"))

	<div class="content-container">
		<div class="info-table">
			<table>
				<tr>
					<td class="input-title">邮箱：</td>
					<td class="input">
						<input type="text" placeholder="作为登录账号，请填写未被申请注册的邮箱账号"/>
					</td>
				</tr>
				<tr>
					<td class="input-title">密码：</td>
					<td class="input">
						<input type="text" placeholder="字母、数字或英文符号，最短6位，区分大小写"/>
					</td>
				</tr>
				<tr>
					<td class="input-title">确认密码：</td>
					<td class="input">
						<input type="text" placeholder="请再次输入密码"/>
					</td>
				</tr>
				<tr>
					<td class="input-title">验证码：</td>
					<td class="input validate-input">
						<input type="text" placeholder=""/>
						<div class="validate-img">
							<img src="/images/login/logo.png">
						</div>
						<a href="javascript:">
							换一换
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="info-protocol">
			<label for="protocol">
				<input type="checkbox" id="protocol"/>
				我同意并遵守《平台协议》
			</label>
		</div>
		<div class="submin-btn">
			<a href="javascirpt:">
				<div class="btn">
					<span>注册</span>
				</div>
			</a>
		</div>
		<div class="info-login">
			<span>已有账号？</span>
			<span><a href="/">立即登录</a></span>
		</div>
	</div>

</div>

@stop
