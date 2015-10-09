
indentNum = $("#indent-number")
indentInputs = $(".indent-inputs")
plate = indentNum.find("select").eq(0).find("option:selected").text()
plateNum = $(".plate-num")
carType = indentNum.find("select").eq(1).find("option:selected").val()

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

	$.get "", {}, (msg)->
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