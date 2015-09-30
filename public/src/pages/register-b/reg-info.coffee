Uploader = require "./../../common/uploader/index.coffee"

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

	# 文件格式
	fileConfig = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp']

	# 文件上传类
	setUploadedPhoto = (name)->
		uploader = new Uploader {
			domain: "http://7xj0sp.com1.z0.glb.clouddn.com/"	# bucket 域名，下载资源时用到，**必需**
			browse_button: name + '_file',       # 上传选择的点选按钮，**必需**
			container: name + '_wrapper',      
		}, {
			FilesAdded: (up, files)->
				# console.log files[0].type
				if not (files[0].type in fileConfig)
	           		alert '请上传"jpg"或"jefg"或"png"或"gif"格式的图片'
	           		up.removeFile(files[0])

			BeforeUpload: (up, file)->

			FileUploaded: (up, file, info)->
				info = $.parseJSON info
				domain = up.getOption('domain')
				url = domain + info.key

				
		}


	#“提交按钮”信息提交函数
	submitInfo = ()->

		$.post "/user/info_register", {
			business_name: companyName,
			business_licence_no: licenseCode,
			business_licence_scan_path: licenseScan,
			bank_account: publicAcc,
			deposit_bank: ,
			bank_outlets: ,
			operational_name: ,
			operational_card_no: ,
			operational_phone: ,
			id_card_front_scan_path: ,
			id_card_back_scan_path: 
		}













