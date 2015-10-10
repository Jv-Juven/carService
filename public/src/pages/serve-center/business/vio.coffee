validate = require "./../../../common/validate/validate.coffee"
warn = require "./../../../common/warn/warn.coffee"
allCheck = require "./../../../common/allcheckbox/all-checkbox.coffee"

validate = new validate()
warn = new warn()
allCheck = new allCheck()

recordsPlate = $(".records-plate")
plateNum = $("#vio_plate_num")
engineNum = $("#engine_num")
plateNumberSelect = $(".plate-number-container").find("select")

vioBtn = $(".vio-btn")
vioTips = $(".vio-warn-tips")

table01 = $(".vio-records-table01")
table02 = $(".vio-records-table02")

th01 = table01.find(".tb-head")
th02 = table02.find(".tb-head")

vioRecords = $(".vio-records")

dealBtn = $(".deal-btn a")

xhArr = []

recordsTotal = $(".records-total")

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

	placeName = plateNumberSelect.eq(0).find("option:selected").text()
	carType = plateNumberSelect.eq(1).find("option:selected").val()
	
	vioTips.text(" ")

	licensePlate = placeName + plateNum.val()

	$.get "/serve-center/search/api/violation", {

		engineCode: engineNum.val(),
		licensePlate: licensePlate,
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

			th01.after tpl01
			th02.after tpl02

			#修改标题头
			recordsPlate.text(licensePlate)
			recordsTotal.text(msg["violations"].length)

			vioRecords.fadeIn 100,()->
				#"全选"按钮绑定事件
				allCheck.bindEvent(table01.find(".tb-head input[type='checkbox']"), table01.find(".tb-tr input[type='checkbox']"))
				allCheck.bindEvent(table02.find(".tb-head input[type='checkbox']"), table02.find(".tb-tr input[type='checkbox']"))





#“违章办理”按钮事件
dealVio = ()->
	length = table01.find(".tb-tr .checkbox").length
	table01.find(".tb-tr .checkbox").each (index, item)->
		_this = $ item
		if _this.prop("checked")
			xhArr.push parseInt(_this.attr("data-xh"))
		if index is (length - 1)
			if xhArr.length is 0
				warn.alert "请选中要办理的违章记录！"
				return
			else
				$.post "/serve-center/agency/business/confirm_violation", {
					xh: xhArr
				}, (msg)->
					if msg["errCode"] isnt 0
						alert msg["message"]
					







$ ()->
	#违章查询的“确定”按钮绑定事件
	vioBtn.on "click", submit
	#“违章办理”按钮事件绑定
	dealBtn.on "click", dealVio
	










