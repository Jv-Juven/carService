
validate = require "./../../common/validate/validate.coffee"
warn = require "./../../common/warn/warn.coffee"
mask = require "./../../components/mask/mask.coffee"
strMask = require "./../../common/strMask/str-mask.coffee"
timing =require "./../../common/settimeout/settimeout.coffee"

validate = new validate()
warn = new warn()


changeInfoBtn = $(".change-info")
changePsdBtn = $(".change-psd")

phone = $("#phone_num")

maskBg = $(".mask-bg")
changePassword = $(".change-password")
changeInfomation = $(".change-information")

getPhoneCodesBtn = $(".psd-get-phone-codes")

###
# 修改密码表单信息 START
###
psdPhoneCode = $(".psd-phone-code")
oldPassword = $(".old-password")
password = $(".psd-password")
rePassword = $(".psd-repassword")
###
# 修改密码表单信息 END
###

accTips = $(".account-tips")
psdTips = $(".psd-tips")

psdSaveBtn =$(".psd-save-btn")
psdCancelBtn =$(".psd-cancel-btn")

show = {

	#显示“修改密码”框
	showChangePsd: ()->
		psdTips.html("")
		maskBg.fadeIn(100)
		changePassword.fadeIn(100)

	#显示“修改运营者信息”框
	showChangeInfo: ()->
		accTips.html("")
		maskBg.fadeIn(100)
		changeInfomation.fadeIn(100)
}



psd = {

	#获取手机验证码
	getPhoneCodes: (e)->
		_this = $(e.currentTarget)
		$.post "/user/send_code_to_phone", {}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]
			else
				timing(_this, 60, ()->
					_this.on "click", psd.getPhoneCodes
				)
				alert msg["message"]

	#保存修改的密码
	savePsd: ()->

		if !validate.charCodes(psdPhoneCode.val())
			psdPhoneCode.focus()
			psdTips.text("*请正确输入验证码")
			return
		if password.val().length < 6
			password.focus()
			psdTips.text("*请输入不少于六位的密码")
			return
		if rePassword.val().length < 6
			rePassword.focus()
			psdTips.text("*请再次输入密码")
			return
		
		$.post "/user/reset_csite_pwd", {
			#验证码
			phone_code: psdPhoneCode.val(),
			#密码
			password: password.val(),
			#确认密码
			re_password: rePassword.val()

			}, (msg)->
				if msg["errCode"] isnt 0
					alert msg["message"]
				else
					warn.alert "保存成功"
					location.reload()


}


$ ()->
	phone.text strMask(phone.text(), 4, 8, "*")
	#“修改密码”按钮绑定事件
	changePsdBtn.on "click", show.showChangePsd
	#修改密码的"获取手机验证码"按钮绑定事件
	getPhoneCodesBtn.on "click", psd.getPhoneCodes
	#修改密码"保存"按钮绑定事件
	psdSaveBtn.on "click", psd.savePsd
	#修改密码"取消"按钮绑定事件
	psdCancelBtn.on "click", mask.closeMask













