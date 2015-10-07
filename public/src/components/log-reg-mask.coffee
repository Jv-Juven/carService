validate = require "./../common/validate/validate.coffee"
warn = require "./../common/warn/warn.coffee"

validate = new validate()
warn = new warn()

closeBtn = $(".warn-close")
bg = $(".log-reg-bg, .mask-bg")
wrapper = $(".log-reg-wrapper, .mask-wrapper")
floatLayout = $(".mask, #mask")
logEmail = $(".log-email")
logPhone = $(".log-phone")
password = $("#login_password")
logMenuBtn = $(".warn-content-title .login-menu-btn")
personalRegBtn =$(".personal-reg")
loginMask = $(".mask-login")
regMask = $(".mask-register")
inputTips = $(".input-tips-line .input-tips")
submitBtn = $(".forget-submit .submit-btn")
userType = 0 #用户类型， 0为企业用户， 1为个人用户
regPhone = $(".log-reg-phone")
regValidateCodes = $(".reg-validate")
getCodes = $(".get-validate-codes")
regTips = $(".warn-tips input")
regPassword = $(".reg-password")
regRePassword = $(".reg-repassword")
regBtn = $(".personal-reg-btn")
cancelBtn = $(".personal-cancel-btn")
fotgetPsd = $(".forget-tips")

###
# 忘记密码框 START
###

resetClose = $(".mask-reset-psd .warn-close")

changeEmail = $(".change-email")
changePhone = $(".change-phone")
maskBg = $(".mask-bg")
maskResPsd = $(".mask-reset-psd")

emailInput = $(".change-email .email-input")
phoneInput = $(".change-phone .phone-input")

emailCodesBtn = $(".get-email-codes")
emailCodes = $(".email-codes")
phoneCodesBtn = $(".get-phone-codes")
phoneCodes = $(".phone-codes")

newPsd = $(".new-password")
renewPsd = $(".re-new-password")

saveBtn = $(".save-btn")
cancelBtn =$(".cancel-btn")

warnTips = $(".find-psd-tips input")

###
# 忘记密码框 END
###


#显示“个人注册”框
showPersReg = ()->
	$(".log-reg-bg").fadeIn(100)
	$(".mask-register").fadeIn(100)

#关闭按钮事件
closeMask = ()->
	bg.fadeOut(200)
	wrapper.fadeOut(200)
	floatLayout.fadeOut(200)
	regTips.val(" ")

#切换不同用户类型登录
cutUserType =  (e)->
	_this = $(e.currentTarget)
	_index = _this.index()
	logMenuBtn.removeClass("active").eq(_index).addClass "active"
	userType = _index
	if _index is 0
		logPhone.hide()
		logEmail.show()
	else
		logEmail.hide()
		logPhone.show()

#企业用户登录
userLogin = ()->

	if userType is 0
		if !validate.email(logEmail.find(".input input").val())
			inputTips.text("*请输入正确的邮箱")
			return
		if password.val().length < 6
			inputTips.text("*请输入不少于6位的密码")
			return

		$.post "/user/login", {
			email: logEmail.find(".input input").val(),
			password: password.val()
		}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]
	else
		if !validate.mobile(logPhone.find(".input input").val())
			inputTips.text("*请输入正确的手机号码")
			return
		if password.val().length < 6
			inputTips.text("*请输入不少于6位的密码")
			return

		$.post "/user/login", {
			email: logPhone.find(".input input").val(),
			password: password.val()
		}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]

#切换到个人用户注册
personal = ()->
	loginMask.hide()
	regMask.show()


#个人注册按钮
personalReg = ()->
	
	if !validate.mobile(regPhone.val())
		regTips.val("*请正确填写手机号码")
		regPhone.focus()
		return
	if !validate.charCodes(regValidateCodes.val())
		regTips.val("*请正确填写手机验证码")
		regValidateCodes.focus()
		return
	if regPassword.val().length < 6
		regTips.val("*请填写不少于6位的密码")
		regPassword.focus()
		return
	if regRePassword.val().length < 6
		regTips.val("*请再次输入密码")
		regRePassword.focus()
		return

	$.post "/user/c_register", {
		login_account: regPhone.val(),
		password: regValidateCodes.val(),
		re_password: regPassword.val(),
		phone_code: regRePassword.val()
	}, (msg)->
		if msg["errCode"] isnt 0
			regTips.val(msg["message"])


#关闭按钮绑定事件
closeBtn.on "click", closeMask
#切换用户类型按钮绑定事件
logMenuBtn.on "click",cutUserType
#”个人用户注册“按钮绑定事件
personalRegBtn.on "click", personal

#手机获取验证码
getCodes.on "click", ()->

	if !validate.mobile(regPhone.val())
		regTips.val("*请正确填写手机号码")
		return

	$.post "/user/phone_code", {
		login_account: regPhone.val()
	}, (msg)->
		if msg["errCode"] isnt 0
			regTips.val(msg["message"])
			return

#"登录"按钮绑定事件
submitBtn.on "click", userLogin

#"注册"按钮绑定事件
regBtn.on "click", personalReg

#"取消"按钮绑定事件
cancelBtn.on "click", closeMask


###
# 忘记密码框 START
###

#显示”忘记密码“框
showResetPannel = ()->
	
	if userType is 0
		changePhone.hide()
		changeEmail.show()
		maskBg.fadeIn(100)
		maskResPsd.fadeIn(100)
	else
		changeEmail.hide()
		changePhone.show()
		maskBg.fadeIn(100)
		maskResPsd.fadeIn(100)

#"忘记密码"框关闭按钮事件
closeReg = ()->
	maskBg.fadeOut(100)
	maskResPsd.fadeOut(100)
	warnTips.val(" ")

#修改密码
resetPsd = ()->

	if userType is 0

		if !validate.charCodes(emailCodes.val())
			warnTips.val("*请正确填写邮箱验证码")
			emailCodes.focus()
			return
		if newPsd.val().length is 0
			warnTips.val("*请填写新密码")
			newPsd.focus()
			return
		if renewPsd.val().length is 0
			warnTips.val("*请再次填写密码")
			renewPsd.focus()
			return

		$.post "/user/reset_bsite_pwd", {
			reset_code: emailCodes.val(),
			password: newPsd.val(),
			re_password: renewPsd.val()
		}, (msg)->
			if msg["errCode"] isnt 0
				warn.alert msg["message"]
	else

		if !validate.mobile(phoneInput.val())
			warnTips.val("*请填写手机号码")
			phoneInput.focus()
			return
		if !validate.charCodes(phoneCodes.val())
			warnTips.val("*请正确填写手机验证码")
			phoneCodes.focus()
			return
		if newPsd.val().length is 0
			warnTips.val("*请填写新密码")
			newPsd.focus()
			return
		if renewPsd.val().length is 0
			warnTips.val("*请再次填写密码")
			renewPsd.focus()
			return

		$.post "/user/reset_csite_pwd", {
			login_account: phoneInput.val(),
			phone_code: phoneCodes.val(),
			password: newPsd,
			re_password: renewPsd
		}, (msg)->
			if msg["errCode"] isnt 0
				warn.alert msg["message"]


#邮箱获取验证码
emailCodesBtn.on "click", ()->

	if !validate.email(emailInput.val())
		warnTips.val("*请正确填写邮箱")
		emailInput.focus()
		return

	$.post "/user/send_code_to_email", {
		login_account: emailInput.val()
	}, (msg)->
		if msg["errCode"] isnt 0
			warn.alert msg["message"]

#手机获取验证码
phoneCodesBtn.on "click", ()->

	if !validate.mobile(phoneInput.val())
		warnTips.val("*请正确填写手机号码")
		phoneInput.focus()
		return

	$.post "/user/phone_code", {
		login_account: phoneInput.val()
	}, (msg)->
		if msg["errCode"] isnt 0
			warn.alert msg["message"]

#修改密码
saveBtn.on "click", resetPsd

#"取消"按钮事件绑定
cancelBtn.on "click", closeReg

#"忘记密码"框关闭按钮事件绑定
resetClose.on "click", closeReg

###
# 忘记密码框 END
###


#在“登录”框里点击显示“忘记密码”框
fotgetPsd.on "click", ()->
	closeMask()
	showResetPannel()

mask = {

	showPersReg: ()->
		showPersReg()

	showResetPannel: ()->
		showResetPannel()

	closeMask: ()->
		closeMask()
}

module.exports = mask









	