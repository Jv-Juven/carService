validate = require "./../../../common/validate/validate.coffee"
warn = require "./../../../common/warn/warn.coffee"

validate = new validate()
warn = new warn()

driverLicense = $("#driver_license")
fileCodes = $("#file_codes")
driveTips = $(".drive-tips")
stress = $(".stress")


#"确定"查询出相关的结果
submit = ()->

	if !validate.creditCard(driverLicense.val())
		driveTips.text "*请正确输入身份证号或驾驶证号"
		return

	if validate.recordId(fileCodes.val())
		driveTips.text "*请正确输入驾驶证上的档案编号"
		return

	driveTips.text("")


	$.post "/serve-center/search/api/license", {
		identityID: driverLicense.val(),
		recordID: fileCodes.val()
	}, (msg)->
		if msg["errCode"] is 0
			stress.text(msg["message"] + "分")