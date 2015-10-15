validate = require "./../../common/validate/validate.coffee"
timing =require "./../../common/settimeout/settimeout.coffee"

validate = new validate()



showBtn = $(".submit-btn a")
mask = $(".mask-bg, .mask-wrapper")

getCodesBtn = $(".get-codes-btn")
codesInput = $(".codes-input")

submitBtn = $(".msg-submit-btn")
devTips = $(".dev-tips")

companyName =$(".company-name")
license = $(".reg-license")

#显示弹框
showBox = ()->
	devTips.html("")
	mask.fadeIn(100)

#获取验证码
getCodes = (e)->
	_this = $(e.currentTarget)
	$.post "/user/send_code_to_email", {}, (msg)->
		if msg["errCode"] isnt 0
			alert msg["message"]
		else
			timing(_this, 60, ()->
				_this.on "click", getCodes
			)
			alert "发送验证码成功"

#提交信息
submitMsg = ()->
	code = codesInput.val()
	if !validate.charCodes(code)
		devTips.text "*请正确输入验证码"
		return

	$.post "/user/display_company_info", {
		display_code: code
	}, (msg)->
		if msg["errCode"] isnt 0
			alert msg["message"]
		else
			alert "提交信息成功"
			companyName.text(msg["app_key"])
			license.text(msg["app_secret"])



$ ()->
	
	#“完整显示”按钮绑定事件
	showBtn.on "click", showBox

	#“获取验证码”按钮绑定事件
	getCodesBtn.on "click", getCodes

	#"提交"按钮绑定事件
	submitBtn.on "click", submitMsg

