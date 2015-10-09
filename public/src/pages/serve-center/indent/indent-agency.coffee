
indentNum = $("#indent-number").val()
indentInputs = $(".indent-inputs")
plate = indentInputs.find("select").eq(0).find("option:selected").text()
plateNum = $(".plate-num").val()
carType = indentInputs.find("select").eq(1).find("option:selected").val()

#违章城市
city = $(".indent-city option:selected").text()
#业务状态
status = $(".indent-status option:selected").val()

dateStart = $("#indent_date_start")
dateEnd = $("#indent_date_end")


btns = $(".btns-wrapper .btn")

number = $(".indent-number")
details = $(".indent-details")

#给input选择框绑定日期控件
init_datepicker = ()->

    # jquery datepicker options
    datepicker_options = 
        dateFormat: 'yy-mm-dd'
        changeYear: true

    dateStart.datepicker datepicker_options
    dateEnd.datepicker datepicker_options

#”查询“
submit = ()->

	$.get "/serve-center/order/operation/search", {
			order_id: indentNum,
			car_plate_no: plate + plateNum,
			process_status: status.val(),
			start_date: dateStart.val(),
			end_date: dateEnd
		}, (msg)->
		if msg["errCode"] isnt 0
			alert msg["message"]
		else
			


#切换信息填写
cutInfoInput = (e)->
	_this = $(e.currentTarget)
	if _this.hasClass "active"
		return
	_this.addClass("active").siblings().removeClass("active")
	_index = _this.index()
	if _index is 0
		details.hide()
		number.show()
	else
		number.hide()
		details.show()




$ ()->

	init_datepicker()

	btns.on "click", cutInfoInput









