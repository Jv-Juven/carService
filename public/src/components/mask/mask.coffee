
changePhone = $(".change-phone")
changeEmail = $(".change-email")

maskBg = $(".mask-bg")
maskResPsd = $(".mask-reset-psd")


bg = $(".log-reg-bg, .mask-bg")
wrapper = $(".log-reg-wrapper, .mask-wrapper")

floatLayout = $(".mask, #mask")
regTips = $(".warn-tips input")

loginMask = $(".mask-login")

#显示“登录”框
showLoginMask = ()->
	loginMask.show()
	regMask.show()

#显示“个人注册”框
showPersReg = ()->
	$(".log-reg-bg").fadeIn(100)
	$(".mask-register").fadeIn(100)

#显示”忘记密码“框
showResetPannel = (userType)->
	
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

#关闭按钮事件
closeMask = ()->
	bg.fadeOut(200)
	wrapper.fadeOut(200)
	floatLayout.fadeOut(200)
	regTips.val(" ")

mask = {

	showPersReg: ()->
		showPersReg()

	showResetPannel: (userType)->
		showResetPannel(userType)

	closeMask: ()->
		closeMask()

	showLoginMask: ()->
		showLoginMask()

}

module.exports = mask






