$ ()->
	logBtn = $("#header_regbtn")
	menu = $(".reg-dropdown-list")

	#显示与隐藏”注册“的下拉菜单
	menuToggle = (e)->
		menu.slideToggle(200)

	logBtn.on "click blur", menuToggle