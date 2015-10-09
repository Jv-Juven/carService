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
						<input type="text" id="company_name" placeholder="需与营业执照上的名称完全一致，信息审核成功后，企业名称不可修改" />
					</td>
				</tr>
				<tr>
					<td class="tr-title">营业执照注册号：</td>
					<td class="tr-content">
						<input type="text" id="company_codes" placeholder="请输入15位营业执照注册号或18位的统一社会信用代码" />
					</td>
				</tr>
				<tr>
					<td class="tr-title">营业执照扫描件：</td>
					<td class="tr-content" id="license_wrapper">
						<input type="file" id="license_file" />
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
										<input class="readonly" type="text" id="company_name02" placeholder="" readonly="true" />
									</td>
								</tr>
								<tr>
									<td class="cont-title">对公帐名：</td>
									<td class="cont-content">
										<input type="text" id="public_account" placeholder="请务必正确填写企业对公账户号码"/>
									</td>
								</tr>
								<tr>
									<td class="cont-title">确认对公帐名：</td>
									<td class="cont-content">
										<input type="text" id="re_public_acc" placeholder="请再次输入企业对公账户号码"/>
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
											<option value="01">北京市</option>
											<option value="02">安徽省</option>
											<option value="03">重庆市</option>
											<option value="04">福建省</option>
											<option value="05">广东省</option>
											<option value="06">甘肃省</option>
											<option value="07">广西壮族自治区</option>
											<option value="08">贵州省</option>
											<option value="09">湖南省</option>
											<option value="10">海南省</option>
											<option value="11">湖北省</option>
											<option value="12">河北省</option>
											<option value="13">黑龙江省</option>
											<option value="14">河南省</option>
											<option value="15">天津市</option>
											<option value="16">西藏自治区</option>
											<option value="17">青海省</option>
											<option value="18">浙江省</option>
											<option value="19">辽宁省</option>
											<option value="20">江西省</option>
											<option value="21">新疆维吾尔自治区</option>
											<option value="22">陕西省</option>
											<option value="23">江苏省</option>
											<option value="24">吉林省</option>
											<option value="25">云南省</option>
											<option value="26">宁夏回族自治区</option>
											<option value="27">上海市</option>
											<option value="28">山东省</option>
											<option value="29">山西省</option>
											<option value="30">四川省</option>
											<option value="31">内蒙古自治区</option>
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
						<input id="name" class="text-input long-input" type="text" placeholder="请填写运营者的姓名，如果名字包含分隔号“•”,请勿忽略" />
					</td>
				</tr>
				<tr>
					<td class="tr-title">运营者身份证号码：</td>
					<td class="tr-content" colspan="2">
						<input id="id_card" class="text-input long-input" type="text" placeholder="请填写运营者的身份证号码" />
					</td>
				</tr>
				<tr>
					<td class="tr-title">身份证正面扫描件：</td>
					<td class="tr-content content" id="credit_front_wrapper">
						<input type="file" id="credit_front_file" />
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
					<td class="tr-content content" id="credit_back_wrapper">
						<input type="file" id="credit_back_file" />
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
						<input id="phone" class="text-input short-input" type="text" placeholder="请输入您的手机号码" />
					</td>
					<td class="tr-tips">
						<a class="get-code-btn" href="javascript:">获取验证码</a>
					</td>
				</tr>
				<tr>
					<td class="tr-title">短信验证码：</td>
					<td class="tr-content content">
						<input id="validate_codes" class="text-input short-input" type="text" placeholder="请输入手机短信收到的6位验证码" />
					</td>
					<td class="tr-tips">
						<a class="get-code-btn question-link" href="javascript:">无法收验证码？</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="reg-info-tips"></div>
		<div class="submit-btn reg-info-btn">
			<a href="javascript:">完成</a>
		</div>
	</div>
</div>
@include("components.warn-mask")
@section("js")
	@parent
	<script type="text/javascript" src="/lib/js/plupload.full.min.js"></script>
	<script type="text/javascript" src="/lib/js/qiniu.min.js"></script>
	<script type="text/javascript" src="/dist/js/pages/register-b/reg-info.js"></script>
@stop

@stop
