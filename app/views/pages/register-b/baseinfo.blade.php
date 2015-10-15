@extends("layouts.login-master")


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
						<input id="email" type="text" placeholder="作为登录账号，请填写未被申请注册的邮箱账号"/>
						<span class="warn-tips">请输入正确的邮箱</span>
					</td>
				</tr>
				<tr>
					<td class="input-title">密码：</td>
					<td class="input">
						<input id="password" type="password" placeholder="字母、数字或英文符号，最短6位，区分大小写"/>
						<span class="warn-tips">密码由至少6个字符组成</span>
					</td>
				</tr>
				<tr>
					<td class="input-title">确认密码：</td>
					<td class="input">
						<input id="re_password" type="password" placeholder="请再次输入密码"/>
						<span class="warn-tips">请再次输入密码</span>
					</td>
				</tr>
				<!-- <tr>
					<td class="input-title">验证码：</td>
					<td class="input validate-input">
						<input id="validate_codes" type="text" placeholder=""/>
						<div class="validate-img">
							<img src="/images/login/logo.png">
						</div>
						<a class="change-captcha" href="javascript:">
							换一换
						</a>
					</td>
				</tr> -->
			</table>
		</div>
		<div class="info-protocol">
			<label for="protocol">
				<input type="checkbox" checked="true" id="protocol" name="protocal" value="1" />
				我同意并遵守<a target="_blank" href="http://faq.gzcheshang.com/index.php?action=artikel&cat=3&id=8&artlang=zh">《车尚数据查询平台用户注册协议》</a>
			</label>
			<!-- <span class="warn-tips">请勾选《平台协议》</span> -->
		</div>
		<div class="submin-btn">
			<a class="btn" href="javascirpt:">
				<!-- <div class="btn">
					<span>注册</span>
				</div> -->
				注册
			</a>
		</div>
		<div class="info-login">
			<span>已有账号？</span>
			<span><a href="/">立即登录</a></span>
		</div>
	</div>
</div>
@include("components.warn-mask")
@stop

@section("js")
	@parent
	<script type="text/javascript" src="/dist/js/pages/register-b/baseinfo.js"></script>
@stop
