Uploader = require "./../../common/uploader/index.coffee"

$ ()->

	companyName = $("#company_name")
	companyCode = $("#company_codes")
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

	floatLayout = $(".mask, #mask")
	warnMsg = $(".warn-msg")

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

				$("#" + name + "-wrapper").find(".content-img").removeClass("hidden").find("img").attr("src", url)
				$("#" + name + "-wrapper").find(".img-border").addClass("hidden")
		
				$("#credit-" + name).val url
				$("#" + name + "-file").parent().find(".text").html("重新上传")
				console.log "complete: " + name
		}

