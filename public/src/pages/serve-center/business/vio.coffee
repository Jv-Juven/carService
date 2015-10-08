validate = require "./../../../common/validate/validate.coffee"
warn = require "./../../../common/warn/warn.coffee"

validate = new validate()
warn = new warn()


plateNum = $("#vio_plate_num")
engineNum = $("#engine_num")
plateNumberSelect = $(".plate-number-container").find("select")

vioBtn = $(".vio-btn")
vioTips = $(".vio-warn-tips")

table01 = $(".vio-records-table01")
table02 = $(".vio-records-table02")

th = table01.html()

dealBtn = $(".deal-btn")

#“确定”按钮事件，显示违章查询结果
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

			table01.html("").append(th).append(tpl01).fadeIn(100)
			table02.html("").append(th).append(tpl02).fadeIn(100)



#“违章办理”按钮事件
dealVio = ()->
	table01.find(".tb-tr .checkbox").each ()->
		_this = $(this)

#"全选"多选框事件
selectAll = (e)->
	_this = $(e.currentTarget)
	




$ ()->
	#违章查询的“确定”按钮绑定事件
	vioBtn.on "click", submit
	#“违章办理”按钮事件绑定
	dealBtn.on "click", dealBtn
	#"联系客服"按钮绑定事件












