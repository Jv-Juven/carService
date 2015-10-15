info = require "./../../../components/violation-info.coffee"

carsInputs = $(".cars-inputs")


plateNum = carsInputs.find(".plate-num")
recordId = $(".record-id")

carsBtn = $(".cars-btn")

carsRecords = $(".cars-records")
carsResulte =$(".cars-resulte")

recordPlate = $(".records-plate")

#提交事件
submit = ()->

	carsType = carsInputs.find("select").eq(1).find("option:selected").val()

	plate = carsInputs.find("select").eq(0).find("option:selected").text()
	licensePlate = plate + plateNum.val()

	$.get "/serve-center/search/api/car", {
		engineCode: recordId.val(),
		licensePlate: licensePlate,
		licenseType: carsType
	}, (msg)->
		if msg["errCode"] is 0
			info.fillData(msg["account"]["balance"], msg["account"]["unit"])
			result = _.template $("#cars_template").html()
			result = result {
				"array": msg["car"]
				}
			recordPlate.text(licensePlate)
			carsResulte.html(result)
			carsRecords.show()
		else if msg["errCode"] is 32
			info.fillData(msg["account"]["balance"], msg["account"]["unit"])
			alert msg["message"]
		else if msg["errCode"] > 50
			alert "提示失败"
		else
			alert msg["message"]

$ ()->
	carsBtn.on "click", submit