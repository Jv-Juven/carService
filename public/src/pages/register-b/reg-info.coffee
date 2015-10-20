Uploader = require "./../../common/uploader/index.coffee"
validate = require "./../../common/validate/validate.coffee"
warn = require "./../../common/warn/warn.coffee"
mask = require "./../../components/mask/mask.coffee"
showFileName = require "./../../common/showUploadFileName/showUploadFileName.coffee"
timing =require "./../../common/settimeout/settimeout.coffee"

validate = new validate()
warn = new warn()
$ ()->

	companyName = $("#company_name")
	licenseCode = $("#company_codes")
	licenseScan = ""

	companyName02 = $("#company_name02")
	publicAcc = $("#public_account")
	rePublicAcc = $("#re_public_acc")

	name = $("#name")
	creditCard = $("#id_card")
	creditCardScan01 = ""
	creditCardScan02 = ""
	phone = $("#phone")
	validateCodes = $("#validate_codes")

	submitBtn = $(".reg-info-btn")
	regInfoTips = $(".reg-info-tips")

	#获取手机验证码按钮
	getCodeBtn = $(".reg-info-get-code")

	licensePreg = /[a-zA-Z0-9]{15}|[a-zA-Z0-9]{18}/

	# 文件格式
	fileConfig = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp','image/JPEG', 'image/PNG', 'image/GIF', 'image/BMP']

	# 文件上传类
	setUploadedPhoto = (name)->
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
				# console.log up
				# console.log file

			FileUploaded: (up, file, info)->

				info = $.parseJSON info
				domain = up.getOption('domain')
				url = domain + info.key


				#这里可以改成配置文件
				if name is "license"
					showFileName($("#license_file"), file.name)
					licenseScan = info.key
				if name is "credit_front"
					showFileName($("#credit_front_file"), file.name)
					creditCardScan01 = info.key
				if name is "credit_back"
					showFileName($("#credit_back_file"), file.name)
					creditCardScan02 = info.key

		}

	#获取手机短信验证码
	getPhoneCode = (e)->
		_this = $(e.currentTarget)

		btnText = _this.text()
		#解除按钮事件
		_this.addClass("btn-disabled").text("发送中").off()

		if !validate.mobile(phone.val())
			regInfoTips.text "请输入手机号码"
			return
		$.get "/user/operational_phone_code", {
			telephone: phone.val()
		}, (msg)->
			if msg["errCode"] is 0
				alert msg["message"]
				_this.removeClass("btn-disabled").text(btnText).on("click", getPhoneCode)
			else
				timing(_this, 60, ()->
					_this.on "click", getPhoneCode
				, btnText
				)
				alert msg["message"]

	#“提交按钮”信息提交函数
	submitInfo = ()->

		bank = $(".bank option:selected")
		position = $(".position option:selected")

		if companyName.val().length is 0 or publicAcc.val().length is 0 or rePublicAcc.val().length is 0 or name.val().length is 0 or creditCard.val().length is 0 
			regInfoTips.text("*请确保信息填写完整")
			return

		if !licensePreg.test(licenseCode.val())
			regInfoTips.text("*营业执照注册号为15位或18位")
			return

		if licenseScan is ""
			regInfoTips.text("*请上传营业执照扫描件")
			return

		if creditCardScan01 is ""
			regInfoTips.text("*请上传身份证正面扫描件")
			return

		if creditCardScan02 is ""
			regInfoTips.text("*请上传身份证反面扫描件")
			return

		regInfoTips.text(" ")

		$.post "/user/info_register", {

			business_name: companyName.val(),

			business_licence_no: licenseCode.val(),

			business_licence_scan_path: licenseScan,

			bank_account: publicAcc.val(),

			re_bank_account: rePublicAcc.val(),

			deposit_bank: bank.text(),

			bank_outlets: position.text(),

			operational_name: name.val(),

			operational_card_no: creditCard.val(),

			operational_phone: phone.val(),

			phone_code: validateCodes.val(),

			id_card_front_scan_path: creditCardScan01,

			id_card_back_scan_path: creditCardScan02

		}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]
			else
				alert msg["message"]
				window.location.href = "/user/pending"


	#保持企业名称和户名一致
	companyName.on "change input", ()->
		_val = $(this).val()
		companyName02.val(_val)

	#"获取手机验证码"按钮事件绑定
	getCodeBtn.on "click", getPhoneCode

	#"提交"按钮事件绑定
	submitBtn.on "click", submitInfo

	setUploadedPhoto("license")
	setUploadedPhoto("credit_front")
	setUploadedPhoto("credit_back")















