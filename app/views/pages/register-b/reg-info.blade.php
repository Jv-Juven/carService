@extends("layouts.login-master")

@section("title")
基本信息|注册
@stop

@section("css")
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/register-b/reg-info.css">
@stop

@section("body")

<div class="body-content">
	
	@include("components.reg-process", array("num" => "3"))

	<div class="content-container">
		<div class="reg-explain">
			<span class="title">用户信息登记</span>
			<span class="explain-tips">查询服务平台致力于打造真实、合法、有效的服务平台。为了更好地保障你和广大用户的合法权益，请你认真填写以下信息。</span>
			<span class="explain-tr">用户信息审核通过后：</span>
			<span class="explain-tr">1、你可以依法使用平台的所有服务；</span>
			<span class="explain-tr">2、你对本服务平台的所有行为承担全部责任；</span>
		</div>
		<div class="reg-baseinfo01">
			<span class="title">主体信息登记</span>
			<table class="info-table01">
				<tr>
					<td class="tr-title">企业名称：</td>
					<td class="tr-content">
						<input type="text" placeholder="需与营业执照上的名称完全一致，信息审核成功后，企业名称不可修改" />
					</td>
				</tr>
				<tr>
					<td class="tr-title">营业执照注册号：</td>
					<td class="tr-content">
						<input type="text" placeholder="请输入15位营业执照注册号或18位的统一社会信用代码" />
					</td>
				</tr>
				<tr>
					<td class="tr-title">营业执照扫描件：</td>
					<td class="tr-content" id="reginfo_upload">
						<input type="file" id="upload_btn" />
						<span class="tr-tips">请上传营业执照扫描件</span>
					</td>
				</tr>
				<tr class="last-tr">
					<td class="tr-title">
						<span>对公账户：</span>
					</td>
					<td class="tr-content">
						<div>
							<table>
								<tr>
									<th colspan="3">注册成功后我们将给此对公账户打款1分钱。请尽早贵公司的财务沟通获得打款备注码。 <a href="/" class="check-details">查看详情</a></th>
								</tr>
								<tr>
									<td class="cont-title">户名：</td>
									<td class="cont-content">
										<input type="text" placeholder="请填写企业名称"/>
									</td>
								</tr>
								<tr>
									<td class="cont-title">对公帐名：</td>
									<td class="cont-content">
										<input type="text" placeholder="请务必正确填写企业对公账户号码"/>
									</td>
								</tr>
								<tr>
									<td class="cont-title">确认对公帐名：</td>
									<td class="cont-content">
										<input type="text" placeholder="请再次输入企业对公账户号码"/>
									</td>
									<td class="cont-tips">请务必填写正确，填错造成打款验证失败，会导致账号冻结。</td>
								</tr>
								<tr>
									<td class="cont-title">开户银行：</td>
									<td class="cont-content">
										<select class="bank">
											<option value="">中国工商银行</option>
											<option value="">中国银行</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="cont-title">开户地点：</td>
									<td class="cont-content">
										<select class="position">
											<option value="">中国 广州</option>
											<option value="">中国 杭州</option>
										</select>
									</td>
								</tr>
								<tr class="tr-blank"></tr>
							</table>
						</div>
					</td>
				</tr>
				
			</table>
		</div>
		<div class="reg-baseinfo02">
			<span class="title">主体信息登记</span>
			<table class="info-table02">
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
		</div>
		<div class="submit-btn reg-info-btn">
			<a href="javascript:">完成</a>
		</div>
	</div>

</div>

@stop
