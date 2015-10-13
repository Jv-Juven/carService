validate = require "./../../../common/validate/validate.coffee"
warn = require "./../../../common/warn/warn.coffee"

validate = new validate()
warn = new warn()

name = $("#name")
phone = $("#phone")
address = $("#address")
engineNumber = $("#engine_number")

agency_count = $("#agency_count")
express = $("#express")
plate_num = $("#plate_num").text() + $(".plate-col").text()
sum = $("#sum")
charge = $("#charge")
express_fee = $("#express_fee")

agencyWarnTips = $(".agency-warn-tips")
agencyBtn = $(".agency-btn a")

#sign字段
sign = $("#sign")

submit = ()->

	if express.prop("checked")

		if name.val().length is 0
			agencyWarnTips.text "*请输入收件人姓名"
			return

		if !validate.mobile(phone.val())
			agencyWarnTips.text "*请输入收件人手机号码"
			return

		if address.val().length is 0
			agencyWarnTips.text "*请输入收件人地址"
			return

		# if (!validate.engineNum(engineNumber.val())) || (engineNumber.val().length isnt 4)
		# 	agencyWarnTips.text "*请输入发动机号后4位"
		# 	return

	agencyWarnTips.text(" ")

	$.post "/serve-center/agency/business/", {
		sign: sign.val(),
		is_delivered: express.prop("checked"),
		recipient_name: name.val(),
		recipient_addr: phone.val(),
		recipient_phone: address.val()
	}, (msg)->

		if msg["errCode"] isnt 0 
			alert msg["message"]
		else
			if !msg["order_id"]
				return
			window.location.href = "/serve-center/agency/pay?order_id=" + msg["order_id"].val()
			


$ ()->
	agencyBtn.on "click", submit











