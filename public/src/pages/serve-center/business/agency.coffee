validate = require "./../../../common/validate/validate.coffee"
warn = require "./../../../common/warn/warn.coffee"

validate = new validate()
warn = new warn()

name = $("#name")
phone = $("#phone")
address = $("#address")
engineNumber = $("#engine_number")

# plate_num = $("#plate_num")
agency_count = $("#agency_count")
express = $("#express")
plate_num = $("#plate_num").text() + $(".plate-col").text()
sum = $("#sum")
charge = $("#charge")
express_fee = $("#express_fee")

agencyWarnTips = $(".agency-warn-tips")
agencyBtn = $(".agency-btn a")

submit = ()->
	
	if name.val().length is 0
		agencyWarnTips.text "*请输入收件人姓名"
		return

	if !validate.mobile(phone.val())
		agencyWarnTips.text "*请输入收件人手机号码"
		return

	if address.val().length is 0
		agencyWarnTips.text "*请输入收件人地址"
		return

	if !validate.engineNum(engineNumber.val())
		agencyWarnTips.text "*请输入发动机号后4位"
		return

	$.post "/business/submit_order", {
		is_delivered: express.prop("checked"),
		car_plate_no: plate_num,
		agency_no: agency_count.text(),
		capital_sum: sum.text(),
		service_charge_sum: charge.text(),
		express_fee: express_fee.text(),
		recipient_name: name.val(),
		recipient_addr: phone.val(),
		recipient_phone: address.val(),
		car_engine_no:  engineNumber.val()
	}, (msg)->
		if msg["errCode"] isnt 0 
			alert msg["message"]



$ ()->
	agencyBtn.on "click", submit











