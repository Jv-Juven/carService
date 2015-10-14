validate = require "./../../../common/validate/validate.coffee"
warn = require "./../../../common/warn/warn.coffee"

validate = new validate()
warn = new warn()

engineNumber = $("#engine_number")

agency_count = $("#agency_count")
express = $("#express")
plate_num = $("#plate_num").text() + $(".plate-col").text()
sum = $("#sum")
charge = $("#charge")
express_fee = $("#express_fee")

agencyWarnTips = $(".agency-warn-tips")
agencyBtn = $(".agency-btn a")

agencyBtnCancel = $(".agency-btn-cancel a")

#sign字段
sign = $("#sign")

noNeed = $("#noneed")

#快递单信息表
agencyForm = $(".agency-form")


capitalSum = parseInt($("#capital-sum").val())
serviceFee = parseInt($("#service-fee").val())
expressFee = parseInt($("#express-fee").val())

submit = ()->

	name = $("#name")
	phone = $("#phone")
	address = $("#address")

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

	if express.prop("checked")
		is_delivered = 1
	else
		is_delivered = 0


	$.post "/serve-center/agency/business/submit_order", {
		sign: sign.val(),
		is_delivered: is_delivered,
		recipient_name: name.val(),
		recipient_addr: address.val(),
		recipient_phone: phone.val()
	}, (msg)->

		if msg["errCode"] isnt 0 
			alert msg["message"]
		else
			if !msg["order_id"]
				return
			window.location.href = "/serve-center/agency/pages/pay?order_id=" + msg["order_id"]

cancelDeal = ()->
	$.post "/serve-center/agency/business/cancel_violation", {
		sign: sign.val()
		}, (msg)->
			if msg["errCode"] is 0
				window.location.href = "/serve-center/search/pages/violation"
			else
				alert msg["message"]

			


$ ()->
	agencyBtn.on "click", submit

	agencyBtnCancel.on "click", cancelDeal

	#快递单信息表的现实与隐藏
	express.on "click", ()->
		agencyForm.show()
		sum.text(capitalSum + serviceFee + expressFee)
	noNeed.on "click", ()->
		agencyForm.hide()
		sum.text(capitalSum + serviceFee)













