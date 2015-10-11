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
	@include("components.left-nav.account-center-left-nav")
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
							邮箱验证码：
						</span>
						<input class="msg-input psd-email-code" type="text" placeholder="请前往注册邮箱获取验证码"/>
						<a href="javascript:" class="msg-btn psd-get-email-codes">获取验证码</a>
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
	<div class="mask-wrapper change-information">
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
								<input class="text-input short-input info-email-code" type="text" placeholder="请前往注册邮箱获取验证码" />
							</td>
							<td class="tr-tips">
								<a class="get-code-btn get-email-codes" href="javascript:">获取验证码</a>
							</td>
						</tr>
						<tr>
							<td class="tr-title">运营者身份证姓名：</td>
							<td class="tr-content" colspan="2">
								<input class="text-input long-input info-name" type="text" placeholder="请填写运营者的姓名，如果名字包含分隔号“•”,请勿忽略" />
							</td>
						</tr>
						<tr>
							<td class="tr-title">运营者身份证号码：</td>
							<td class="tr-content" colspan="2">
								<input class="text-input long-input info-credit-num" type="text" placeholder="请填写运营者的身份证号码" />
							</td>
						</tr>
						<tr>
							<td class="tr-title">身份证正面扫描件：</td>
							<td class="tr-content content" id="front_wrapper">
								<input type="file" id="front_file" />
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
							<td class="tr-content content" id="back_wrapper">
								<input type="file" id="upload_btn" id="back_file" />
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
								<input class="text-input short-input info-phone" type="text" placeholder="请输入您的手机号码" />
							</td>
							<td class="tr-tips">
								<a class="get-code-btn get-phone-codes" href="javascript:">获取验证码</a>
							</td>
						</tr>
						<tr>
							<td class="tr-title">短信验证码：</td>
							<td class="tr-content content">
								<input class="text-input short-input info-phone-code" type="text" placeholder="请输入手机短信收到的6位验证码" />
							</td>
							<td class="tr-tips">
								<a class="get-code-btn question-link" href="javascript:">无法收验证码？</a>
							</td>
						</tr>
					</table>
					<div class="tips-words account-tips"></div>
					<div class="account-btns">
						<a class="account-btn info-save-btn" href="javascript:">保存</a>
						<a class="account-btn info-cancel-btn" href="javascript:">取消</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section("js")
	@parent
	<script type="text/javascript" src="/lib/js/plupload.full.min.js"></script>
	<script type="text/javascript" src="/lib/js/qiniu.min.js"></script>
	<script type="text/javascript" src="/dist/js/pages/account-center/account-info.js"></script>
@stop