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

table01 = $(".vio-records-table01")
table02 = $(".vio-records-table02")

th = table01.html()

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

	if (!validate.engineNum(engineNumber.val())) || (engineNumber.val().length isnt 4)
		agencyWarnTips.text "*请输入发动机号后4位"
		return

	agencyWarnTips.text(" ")

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

			warn.alert msg["message"]

		else

			array01 = _.filter msg["violations"], "wfjfs", "0"
			array02 = _.filter msg["violations"], (subArr)->
				return subArr["wfjfs"] > 0

			tpl01 = _.template $("#vio_template").html()
			tpl01 = tpl01({
				"array": array01,
				"service_fee": msg["service_fee"]
				})

			tpl02 = _.template $("#vio_template").html()
			tpl02 = tpl02({
				"array": array02,
				"service_fee": msg["service_fee"]
				})
			
			table01.html("").append(th).append(tpl01)
			table02.html("").append(th).append(tpl02)





$ ()->
	agencyBtn.on "click", submit











