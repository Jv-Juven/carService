validate = require "./../../../common/validate/validate.coffee"
warn = require "./../../../common/warn/warn.coffee"

validate = new validate()
warn = new warn()


plateNum = $("#vio_plate_num")
engineNum = $("#engine_num")
plateNumberSelect = $(".plate-number-container").find("select")

vioBtn = $(".vio-btn")
vioTips = $(".vio-warn-tips")

submit = ()->

	if !validate.engineNum(plateNum.val()) || (plateNum.val().length isnt 6)
		vioTips.text "*请正确填写车牌号码后六位"
		plateNum.val("").focus()
		return

	if !validate.engineNum(engineNum.val()) || (engineNum.val().length isnt 6)
		vioTips.text "*请正确填写发动机号码后六位"
		engineNum.val("").focus()
		return

	place = plateNumberSelect.eq(0).find("option:checked").text()
	carType = plateNumberSelect.eq(1).find("option:checked").val()

	vioTips.text(" ")

	$.post "/business/api/violation", {
		engineCode: engineNum,
		licensePlate: place + plateNum,
		licenseType: carType
		}, (msg)->
		if msg["errCode"] isnt 0
			warn.alert msg["message"]



$ ()->
	vioBtn.on "click", submit
