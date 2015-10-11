
Uploader = require "./../../common/uploader/index.coffee"
validate = require "./../../common/validate/validate.coffee"
warn = require "./../../common/warn/warn.coffee"
mask = require "./../../components/log-reg-mask.coffee"

validate = new validate()
warn = new warn()


changeInfoBtn = $(".change-info")
changePsdBtn = $(".change-psd")

maskBg = $(".mask-bg")
changePassword = $(".change-password")
changeInfomation = $(".change-information")

getEmailCodesBtn = $(".get-email-codes")
getPhoneCodesBtn = $(".get-phone-codes")

psdGetEmailCodes = $(".psd-get-email-codes")

###
# 运营者表单信息 START
###
emailCodes = $(".info-email-code")
infoName = $(".info-name")
infoCreditNum = $(".info-credit-num")
creditScanFront = ""
creditScanBack = ""
infoPhone = $(".info-phone")
infoPhoneCodes = $(".info-phone-code")
saveBtn = $(".info-save-btn")
cancelBtn = $(".info-cancel-btn")
###
# 运营者表单信息 END
###


###
# 修改密码表单信息 START
###
psdEmailCode = $(".psd-email-code")
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


# 文件格式
fileConfig = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp','image/JPEG', 'image/PNG', 'image/GIF', 'image/BMP']

# 文件上传函数
setUploadedPhoto = (name, val)->
	uploader = new Uploader {
		# domain: "7xnenz.com1.z0.glb.clouddn.com/"	# bucket 域名，下载资源时用到，**必需**
		browse_button: name + '_file',       # 上传选择的点选按钮，**必需**
		container: name + '_wrapper',      
	}, {
		FilesAdded: (up, files)->
			# console.log files[0].type
			if not (files[0].type in fileConfig)
				warn.alert '请上传"jpg"或"jefg"或"png"或"gif"格式的图片'
				up.removeFile(files[0])

		BeforeUpload: (up, file)->

		FileUploaded: (up, file, info)->
			info = $.parseJSON info
			domain = up.getOption('domain')
			url = domain + info.key

			val = url
			
	}
	return val


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

info = {

	#获取邮箱验证码
	getEmailCodes: ()->
		$.post "/user/update_operator_code", {}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]
			else
				alert "验证码已成功发送"

	#获取手机验证码
	getPhoneCodes: ()->
		$.post "/user/operational_phone_code", {}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]
			else
				alert "验证码已成功发送"

	#提交修改后的运营者信息
	submitInfo: ()->

		if !validate.charCodes(emailCodes.val())
			accTips.text "*请正确填写邮箱验证码" 
			return
		if infoName.val().length is 0
			accTips.text "*请填写运营者姓名"
			return
		if !validate.creditCard(infoCreditNum.val())
			accTips.text "*请正确填写运营者身份证号码"
			return
		if creditScanFront.length is 0
			accTips.text "*请上传身份证正面扫描件"
			return
		if creditScanBack.length is 0
			accTips.text "*请上传身份证反面扫描件"
			return
		if !validate.mobile(infoPhone.val())
			accTips.text "*请正确填写运营者手机号码"
			return
		if !validate.charCodes(infoPhoneCodes.val())
			accTips.text "*请正确填写运营者手机短信验证码"
			return

		$.post "/user/save_operator_info", {
				#邮箱验证码
				email_code: emailCodes,
				#手机号码
				operational_phone: infoPhone,
				#手机验证码
				phone_code: infoPhoneCodes,
				#运营者姓名
				operational_name: infoName,
				#运营者身份证号码
				operational_card_no: infoCreditNum,
				#身份证正面扫描件
				id_card_front_scan_path: creditScanFront,
				#身份证反面扫描件
				id_card_back_scan_path: creditScanBack

			}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]
			else
				warn.alert "保存成功"
}

psd = {

	#获取邮箱验证码
	getEmailCodes: ()->
		$.post "/user/send_code_to_email", {
			}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]

	#保存修改的密码
	savePsd: ()->

		if !validate.charCodes(psdEmailCode.val())
			psdTips.text("*请正确输入验证码")
			return
		if password.val().length < 6
			psdTips.text("*请输入不少于六位的密码")
			return
		if rePassword.val().length < 6
			psdTips.text("*请再次输入密码")
			return
		
		$.post "/", {
			#验证码
			reset_code: psdEmailCode.val(),
			#密码
			password: password.val(),
			#确认密码
			re_password: rePassword.val()

			}, (msg)->
				if msg["errCode"] isnt 0
					alert msg["message"]
				else
					warn.alert "保存成功"


}


$ ()->
	#“修改运营者信息”按钮绑定事件
	changeInfoBtn.on "click", show.showChangeInfo
	#“修改密码”按钮绑定事件
	changePsdBtn.on "click", show.showChangePsd
	#修改运营者信息“保存”按钮事件绑定
	saveBtn.on "click", info.submitInfo
	#修改运营者信息"取消"按钮事件绑定
	cancelBtn.on "click", mask.closeMask
	#"获取邮箱验证码"按钮绑定事件
	getEmailCodesBtn.on "click", info.getEmailCodes
	#"获取手机验证码"按钮绑定事件
	getPhoneCodesBtn.on "click", info.getPhoneCodes
	#修改密码的"获取邮箱验证码"按钮绑定事件
	psdGetEmailCodes.on "click", psd.getEmailCodes
	#修改密码"保存"按钮绑定事件
	psdSaveBtn.on "click", psd.savePsd
	#修改密码"取消"按钮绑定事件
	psdCancelBtn.on "click", mask.closeMask

	#为上传按钮绑定上传事件
	creditScanFront = setUploadedPhoto("front", creditScanFront)
	creditScanBack = setUploadedPhoto("back", creditScanBack)














