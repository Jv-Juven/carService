Uploader = require "./../../common/uploader/index.coffee"
validate = require "./../../common/validate/validate.coffee"
warn = require "./../../common/warn/warn.coffee"

validate = new validate()
warn = new warn()
$ ()->

	companyName = $("#company_name")
	licenseCode = $("#company_codes")
	licenseScan = ""

	companyName02 = $("#company_name02")
	publicAcc = $("#public_account")
	rePublicAcc = $("#re_public_acc")
	bank = $(".bank option:selected")
	position = $(".position option:selected")

	name = $("#name")
	creditCard = $("#id_card")
	creditCardScan01 = ""
	creditCardScan02 = ""
	phone = $("#phone")
	validateCodes = $("#validate_codes")

	submitBtn = $(".reg-info-btn")
	regInfoTips = $(".reg-info-tips")

	licensePreg = /[a-zA-Z0-9]{15}|[a-zA-Z0-9]{18}/

	# 文件格式
	fileConfig = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp','image/JPEG', 'image/PNG', 'image/GIF', 'image/BMP']

	# 文件上传类
	setUploadedPhoto = (name, val)->
		uploader = new Uploader {
			domain: "http://7xj0sp.com1.z0.glb.clouddn.com/"	# bucket 域名，下载资源时用到，**必需**
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


	#“提交按钮”信息提交函数
	submitInfo = ()->

		if companyName.val().length is 0 or publicAcc.val().length is 0 or rePublicAcc.val().length is 0 or name.val().length is 0 or creditCard.val().length is 0 or !licensePreg.test(licenseCode.val())
			regInfoTips.text("*请确保信息填写完整")
			return

		if $("#license_file").val() is "" or $("#credit_front_file").val() is "" or $("#credit_back_file").val() is ""
			regInfoTips.text("*请上传相关文件")
			return

		$.post "/user/info_register", {

			business_name: companyName.val(),

			business_licence_no: licenseCode.val(),

			business_licence_scan_path: licenseScan,

			bank_account: publicAcc.val(),

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
				warn.alert msg["errCode"]

			else
				window.location.href = ""


	#保持企业名称和户名一致
	companyName.on "change input", ()->
		_val = $(this).val()
		companyName02.val(_val)

	#"提交"按钮事件绑定
	submitBtn.on "click", submitInfo

	license = setUploadedPhoto("license", licenseScan)
	creditFront = setUploadedPhoto("credit_front", creditCardScan01)
	creditBack = setUploadedPhoto("credit_back", creditCardScan02)















