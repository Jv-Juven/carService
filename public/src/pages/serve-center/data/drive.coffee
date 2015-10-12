validate = require "./../../../common/validate/validate.coffee"
warn = require "./../../../common/warn/warn.coffee"
info = require "./../../../components/violation-info.coffee"

validate = new validate()
warn = new warn()

driverLicense = $("#driver_license")
fileCodes = $("#file_codes")
driveTips = $(".drive-tips")
stress = $(".stress")
driveResult =$(".drive-results")

driveBtn = $(".drive-btn")


#"确定"查询出相关的结果
submit = ()->

	if !validate.creditCard(driverLicense.val())
		driveTips.text "*请正确输入身份证号或驾驶证号"
		return

	if (!validate.recordId(fileCodes.val())) || (fileCodes.val().length isnt 12)
		driveTips.text "*请正确输入驾驶证上的档案编号"
		return

	driveTips.text("")

	$.get "/serve-center/search/api/license", {
		identityID: driverLicense.val(),
		recordID: fileCodes.val()
	}, (msg)->
		if msg["errCode"] is 0
			info.fillData(msg["account"]["balance"], msg["account"]["unit"])
			stress.text(msg["message"] + "分")
			driveResult.show()
		else
			alert msg["message"]


$ ()->
	driveBtn.on "click", submit
