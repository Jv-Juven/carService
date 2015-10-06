validate = require "./../../common/validate/validate.coffee"
warn = require "./../../common/warn/warn.coffee"

validate = new validate()
warn = new warn()

$ ()->

	menuBtns = $(".login-content-title .login-menu-btn")
	personalReg = $("#personalReg")
	accNum = $("#account_num")
	psd = $("#password")
	loginBtn = $(".login-content-btn")
	loginTips = $(".login-tips")
	userType = 0 #用户类型， 0为企业用户， 1为个人用户
	tipsBtn = $(".tips02")
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

	#修改“个人用户”和“企业用户”输入框里的提示
	changeStatus = (e)->
		_this = $(e.currentTarget)
		if _this.hasClass "active"
			return
		menuBtns.removeClass "active"
		_this.addClass "active"
		userType = _this.index()
		if _this.index() is 0
			accNum.attr "placeholder", "邮箱"
		else
			accNum.attr "placeholder", "手机号码"

	#登录事件
	login = ()->
		if userType is 0
			if !validate.email(accNum.val())
				loginTips.text("*请填写正确的邮箱")
				return

			if psd.val().length < 6
				loginTips.text("*请填写不少于6位的密码")
				return

			$.post "/user/login", {
				email: accNum.val(),
				password: psd.val()
			}, (msg)->
				if msg["errCode"] isnt 0
					alert msg["message"]

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

	#“个人注册”框出现
	showPersReg = ()->
		$(".log-reg-bg").fadeIn(100)
		$(".mask-register").fadeIn(100)

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

	#“登录”按钮事件绑定
	loginBtn.on "click", login

	#用户类型选择菜单
	menuBtns.on "click", changeStatus

	#"个人注册"按钮事件绑定
	personalReg.on "click", showPersReg

	#"忘记密码"按钮事件绑定
	tipsBtn.on "click", showResetPannel

	#"注册"按钮事件绑定
	resetClose.on "click", closeReg

	###
	# 忘记密码 START
	###

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


	###
	# 忘记密码 END
	###








