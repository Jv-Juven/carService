headerItems = $(".header-menu-item")

leftItems = $(".left-nav .nav-item").parent()

#悬浮效果修改锁，0为可为按钮添加hover或者指定的悬浮样式类，1为锁定不添加
tag = 0

###
# 鼠标悬浮按钮样式改变
# 参数headerItems为jQuery对象
###
hover = (headerItems)->
	headerItems.on "mouseenter", ()->
		if $(this).hasClass("active")
			tag = 1
			return
		$(this).addClass "hover"
	headerItems.on "mouseleave", ()->
		if tag is 1
			tag = 0
			return
		$(this).removeClass "hover"

hover(headerItems)
hover(leftItems)

