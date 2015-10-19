placeholder = require "./../../common/placeholder/placeholder.coffee"

inputs = [
	[".login-content #account_num", "邮箱"],
	[".login-content #password", "密码"],
	[".violation-search #vio_plate_num", "车牌号码后六位"],
	[".violation-search #engine_num", "请输入发动机号码后六位"],
	[".violation-search #cars_plate_num", "车牌号码后六位"],
	[".violation-search #cars_engint_num", "请输入发动机号码后六位"],
	[".violation-search #driver_license", "请输入您的身份证号或驾驶证号"],
	[".violation-search #file_codes", "请输入您驾驶证上的档案编号"],
	[".agency-form #name", "请输入接受违章办理票证的收件人姓名"],
	[".agency-form #phone", "用于接受办理进度短信或紧急联系"],
	[".agency-form #address", "签收违章办理凭证的地址"],
	["#indent-number", "请输入发动机号码后6位"],
	["#indent_agency_plate_num", "车牌号码后六位"],
	[".info-table #email", "作为登录账号，请填写未被申请注册的邮箱账号"],
	[".info-table #password", "字母、数字或英文符号，最短6位，区分大小写"],
	[".info-table #re_password", "请再次输入密码"],
	[".reg-baseinfo01 #company_name", "需与营业执照上的名称完全一致，信息审核成功后，企业名称不可修改"],
	[".reg-baseinfo01 #company_codes", "请输入15位营业执照注册号或18位的统一社会信用代码"],
	[".reg-baseinfo01 #public_account", "请务必正确填写企业对公账户号码"],
	[".reg-baseinfo01 #re_public_acc", "请再次输入企业对公账户号码"],
	[".reg-baseinfo02 #name", "请填写运营者的姓名，如果名字包含分隔号“•”,请勿忽略"],
	[".reg-baseinfo02 #id_card", "请填写运营者的身份证号码"],
	[".reg-baseinfo02 #phone", "请输入您的手机号码"],
	[".reg-baseinfo02 #validate_codes", "请输入手机短信收到的6位验证码"],
	[".write-codes-input", "请输入打款备注码"],
	["#account_info_c_phone_codes", "请查看手机获取验证码"],
	["#account_info_c_password", "字母、数字或者英文符号，最短6位，区分大小写"],
	["#account_info_c_repassword", "请再次输入密码"],
	["#account_info_mask .psd-email-code", "请前往注册邮箱获取验证码"],
	["#account_info_mask .psd-password", "字母、数字或者英文符号，最短6位，区分大小写"],
	["#account_info_mask .psd-repassword", "请再次输入密码"],
	[".change-information .info-email-code", "请前往注册邮箱获取验证码"],
	[".change-information .info-name", "请填写运营者的姓名，如果名字包含分隔号“•”,请勿忽略"],
	[".change-information .info-credit-num", "请填写运营者的身份证号码"],
	[".change-information .info-phone", "请输入您的手机号码"],
	[".change-information .info-phone-code", "请输入手机短信收到的6位验证码"],
	["#developer_get_codes", "请前往注册邮箱获取验证码"],
	[".mask-login #phone", "请输入手机号码"],
	[".mask-login #email", "请输入邮箱"],
	[".mask-login #login_password", "请输入密码"],
	[".mask-register .log-reg-phone", "请输入手机号码"],
	[".mask-register .reg-validate", "请输入短信验证码"],
	[".mask-register .reg-password", "请输入密码"],
	[".mask-register .reg-repassword", "请再次输入密码"],
	[".change-email .email-input", "请输入注册的邮箱"],
	[".change-email .email-codes", "请前往注册邮箱获取验证码"],
	[".change-email .phone-input", "请输入注册的手机号码"],
	[".change-email .phone-codes", "请查看注册手机的短信验证码"],
	[".change-email .new-password", "字母、数字或者英文符号，最短6位，区分大小写"],
	[".change-email .re-new-password", "请再次输入密码"],
]

$ ()->
	if $.browser.msie
		if $.browser.version < 10
			$.each inputs, (i, value)->
				# console.log value
				placeholder.apply null, value


