$ ()->
	closeBtn = $(".warn-close")
	bg = $(".log-reg-bg")
	wrapper = $(".mask-wrapper")
	floatLayout = $(".mask, #mask")

	closeBtn.on "click", ()->
		bg.fadeOut(200)
		wrapper.fadeOut(200)
		floatLayout.fadeOut(200)