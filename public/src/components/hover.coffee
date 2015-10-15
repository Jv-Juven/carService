headerItems = $(".header-menu-item")

leftItems = $(".left-nav .nav-item").parent()

tag = 0

hover = (headerItems)->
	headerItems.on "mouseenter", ()->
		if $(this).hasClass("active")
			tag = 1
			return
		$(this).addClass "active"
	headerItems.on "mouseleave", ()->
		if tag is 1
			tag = 0
			return
		$(this).removeClass "active"

hover(headerItems)
hover(leftItems)

