@extends("layouts.submaster")

@section("title")
开发者信息
@stop

@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/common/mask/mask.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/account-center/account-info.css">
@stop

@section("left-nav")
	@include("components.left-nav.serve-left-nav")
@stop

@section("right-content")
	<div class="content-box">
		<div class="content-container">
			
			<div class="title">
				注册信息登记
			</div>
			<div class="developer-tr">
				<div class="tr tr-title">企业名称：</div>
				<div class="tr tr-content">广州车尚科技有限公司</div>
			</div>
			<div class="developer-tr">
				<div class="tr tr-title">营业执照注册号：</div>
				<div class="tr tr-content">1234567890946342628495060</div>
			</div>

			<div class="title">
				运营者信息登记
			</div>
			<div class="developer-tr">
				<div class="tr tr-title">运营者身份证姓名：</div>
				<div class="tr tr-content">卢**</div>
				<a class="change-info" href="javascript:">修改运营者信息</a>
			</div>
			<div class="developer-tr">
				<div class="tr tr-title">运营者身份证号码：</div>
				<div class="tr tr-content">4405**********9507</div>
			</div>
			<div class="developer-tr">
				<div class="tr tr-title">运营者手机号码：</div>
				<div class="tr tr-content">189*****325</div>
			</div>

			<div class="title">
				注册信息
			</div>
			<div class="developer-tr">
				<div class="tr tr-title">登录邮箱：</div>
				<div class="tr tr-content">hjs@zerioi.com</div>
				<a class="change-psd" href="javascript:">修改密码</a>
			</div>

		</div>
	</div>
	<div class="mask-bg"></div>		
	<div class="mask-wrapper" style="display: none;">
		<div class="warn-box">
			<div class="warn-title">
				修改密码
				<span class="warn-close">×</span>
			</div>
			<div class="warn-content">
				<div class="warn-msg">
					<div class="msg-line">
						<span class="msg-title">
							邮箱验证码：
						</span>
						<input class="msg-input" type="text" placeholder="请前往注册邮箱13********@***.com获取验证码"/>
						<a href="/" class="msg-btn">获取验证码</a>
					</div>
					<div class="msg-line">
						<span class="msg-title">
							原密码：
						</span>
						<input class="msg-input" type="text" placeholder="请填写账号的原密码"/>
					</div>
					<div class="msg-line">
						<span class="msg-title">
							密码：
						</span>
						<input class="msg-input" type="text" placeholder="字母、数字或者英文符号，最短6位，区分大小写"/>
					</div>
					<div class="msg-line">
						<span class="msg-title">
							确认密码：
						</span>
						<input class="msg-input" type="text" placeholder="请再次输入密码"/>
					</div>
				</div>
				<div class="account-btns">
					<a class="account-btn" href="javascript:">保存</a>
					<a class="account-btn" href="javascript:">取消</a>
				</div>
			</div>
		</div>
	</div>
	<div class="mask-wrapper">
		<div class="chang-info-box">
			<div class="warn-title">
				修改运营者信息
				<span class="warn-close">×</span>
			</div>
			<div class="warn-content">
				<div class="warn-msg">
					<table class="info-table02">
						<tr>
							<td class="tr-title">邮箱验证码：</td>
							<td class="tr-content content">
								<input class="text-input short-input" type="text" placeholder="请前往注册邮箱13********@***.com获取验证码" />
							</td>
							<td class="tr-tips">
								<a class="get-code-btn" href="javascript:">获取验证码</a>
							</td>
						</tr>
						<tr>
							<td class="tr-title">运营者身份证姓名：</td>
							<td class="tr-content" colspan="2">
								<input class="text-input long-input" type="text" placeholder="请填写运营者的姓名，如果名字包含分隔号“•”,请勿忽略" />
							</td>
						</tr>
						<tr>
							<td class="tr-title">运营者身份证号码：</td>
							<td class="tr-content" colspan="2">
								<input class="text-input long-input" type="text" placeholder="请填写运营者的身份证号码" />
							</td>
						</tr>
						<tr>
							<td class="tr-title">身份证正面扫描件：</td>
							<td class="tr-content content">
								<input type="file" id="upload_btn" />
							</td>
							<td class="tr-tips">
								<span class="example">
									<span class="example-text">示例</span>
									<img src="/images/register-b/id_card01.png">
								</span>
							</td>
						</tr>
						<tr>
							<td class="tr-title">身份证反面扫描件：</td>
							<td class="tr-content content">
								<input type="file" id="upload_btn" />
							</td>
							<td class="tr-tips">
								<span class="example">
									<span class="example-text">示例</span>
									<img src="/images/register-b/id_card02.png">
								</span>
							</td>
						</tr>
						<tr>
							<td class="tr-title">运营者手机号码：</td>
							<td class="tr-content content">
								<input class="text-input short-input" type="text" placeholder="请输入您的手机号码" />
							</td>
							<td class="tr-tips">
								<a class="get-code-btn" href="javascript:">获取验证码</a>
							</td>
						</tr>
						<tr>
							<td class="tr-title">短信验证码：</td>
							<td class="tr-content content">
								<input class="text-input short-input" type="text" placeholder="请输入手机短信收到的6位验证码" />
							</td>
							<td class="tr-tips">
								<a class="get-code-btn question-link" href="javascript:">无法收验证码？</a>
							</td>
						</tr>
					</table>

					<div class="account-btns">
						<a class="account-btn" href="javascript:">保存</a>
						<a class="account-btn" href="javascript:">取消</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop