
carsInputs = $(".cars-inputs")

plate = carsInputs.find("select").eq(0).find("option:selected").text()
plateNum = carsInputs.find(".plate-num")
carsType = carsInputs.find("select").eq(1).find("option:selected").val()
recordId = $(".record-id")

carsBtn = $(".cars-btn")

carsRecords = $(".cars-records")
carsResulte =$(".cars-resulte")

#提交事件
submit = ()->
	$.get "/serve-center/search/api/car", {
		engineCode: recordId.val()
		licensePlate: plate + plateNum.val()
		licenseType: recordId.val()
	}, (msg)->
		if msg["errCode"] isnt 0
			alert msg["message"]
		else
			result = _.template $("#cars_template").html()
			result = result {
				"array": msg["car"]
				}
			console.log msg["car"]
			carsResulte.append(result)
			carsRecords.show()

$ ()->
	carsBtn.on "click", submit