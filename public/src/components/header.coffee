mask = require "./mask/mask.coffee"

regBtn = $("#header_regbtn")
logBtn = $("#header_logbtn")
menu = $(".reg-dropdown-list")

cRegBtn = $(".reg-dropdown-list .reg-li").eq(0)


#显示与隐藏”注册“的下拉菜单
menuToggle = (e)->
	menu.slideToggle(200)


$ ()->
	#"注册"按钮事件绑定
	regBtn.on "click blur", menuToggle
	#"登录"框显示
	logBtn.on "click", mask.showLoginMask
	#"个人用户"注册弹窗
	cRegBtn.on "click", showPersReg