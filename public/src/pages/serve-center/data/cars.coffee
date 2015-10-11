
carsInputs = $(".cars-inputs")


plateNum = carsInputs.find(".plate-num")
carsType = carsInputs.find("select").eq(1).find("option:selected").val()
recordId = $(".record-id")

carsBtn = $(".cars-btn")

carsRecords = $(".cars-records")
carsResulte =$(".cars-resulte")

recordPlate = $(".records-plate")

#提交事件
submit = ()->

	plate = carsInputs.find("select").eq(0).find("option:selected").text()
	licensePlate = plate + plateNum.val()

	$.get "/serve-center/search/api/cars", {
		engineCode: recordId.val()
		licensePlate: licensePlate
		licenseType: recordId.val()
	}, (msg)->
		if msg["errCode"] isnt 0
			alert msg["message"]
		else
			result = _.template $("#cars_template").html()
			result = result {
				"array": msg["car"]
				}
			recordPlate.text(licensePlate)
			carsResulte.html(result)
			carsRecords.show()

$ ()->
	carsBtn.on "click", submit