validate = require "./../../common/validate/validate.coffee"
warn = require "./../../common/warn/warn.coffee"
mask = require "./../../components/mask/mask.coffee"

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

	bigPics = $(".cases-big-imgs img")
	caseIcon = $(".cases-wrapper .case")

	nocolImg = $(".case-img .nocol-cover")
	colImg = $(".case-img .col-cover")



	
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
				login_account: accNum.val(),
				password: psd.val()
			}, (msg)->
				if msg["errCode"] is 0
					window.location.href = "/serve-center/search/pages/violation"
				# else if msg["errCode"] is 10
				# 	window.location.href = ""
				# else if msg["errCode"] is 11
				# 	window.location.href = ""
				# else if msg["errCode"] is 20
				# 	window.location.href = ""
				# else if msg["errCode"] is 21
				# 	window.location.href = ""
				# else if msg["errCode"] is 30
				# 	window.location.href = ""
				else
					alert msg["message"]
				

	#点击显示指定的大图
	selectPic = (e)->
		_this = $(e.currentTarget)
		_index = _this.index()

		img01 = _this.find(".case-img .nocol-cover")
		img02 = _this.find(".case-img .col-cover")

		nocolImg.show()
		colImg.hide()

		img01.hide()
		img02.show()

		_this.siblings().removeClass("active").end().addClass "active"
		bigPics.hide().eq(_index).show()



	#“登录”按钮事件绑定
	loginBtn.on "click", login

	#用户类型选择菜单
	menuBtns.on "click", changeStatus

	#"个人注册"按钮事件绑定
	personalReg.on "click", mask.showPersReg

	#"忘记密码"链接按钮事件绑定
	tipsBtn.on "click", ()->
		mask.showResetPannel(userType)

	#页面底部icons事件绑定
	caseIcon.on "click", selectPic
	#隐藏所有彩色icon
	colImg.hide()






