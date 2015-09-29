$ ()->

	menuBtns = $(".login-content-title .login-menu-btn")
	emailInput = $(".email-input input")

	#修改“个人用户”和“企业用户”输入框里的提示
	changeStatus = (e)->
		_this = $(e.currentTarget)
		if _this.hasClass "active"
			return
		menuBtns.removeClass "active"
		_this.addClass "active"
		if _this.index() is 0
			emailInput.attr "placeholder", "邮箱"
		else
			emailInput.attr "placeholder", "手机号码"


	menuBtns.on "click", changeStatus
