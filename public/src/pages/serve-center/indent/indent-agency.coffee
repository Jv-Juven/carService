
indentNum = $("#indent-number")
indentInputs = $(".indent-inputs")
plate = indentInputs.find("select").eq(0)
plateNum = $(".plate-num")
carType = indentInputs.find("select").eq(1)

#违章城市
city = $(".indent-city")
#业务状态
status = $(".indent-status")

dateStart = $("#indent_date_start")
dateEnd = $("#indent_date_end")


btns = $(".btns-wrapper .btn")

tableBlank = $(".table-blank")

number = $(".indent-number")
details = $(".indent-details")

submitBtn = $(".indent-btn .indent-submit")

template = $("#indent_template").html()

indentTablesWrapper = $(".indent-tables-wrapper")

cancelDealBtn = $(".cancel-deal")

sureBtn = $(".sure-btn")
cancelBtn = $(".cancel-btn")

maskBg = $(".mask-bg")
cancelMask = $(".cancel-mask")
refundMask = $('.refund-mask')

refundBtn = $(".refund-btn")

tradeStatus = $(".wait-pay")

pagination = $(".paginate-wrap")

#退款“确定”按钮
refundCloseBtn = $("#refund_btn")

payBtn = $(".immediately-pay")

#关闭弹窗
closeMask = ()->
	maskBg.fadeOut(100)
	$(".mask-wrapper").fadeOut(100)


#给input选择框绑定日期控件
init_datepicker = ()->

	# jquery datepicker options
	datepicker_options = 
		dateFormat: 'yy-mm-dd'
		changeYear: true

	dateStart.datepicker datepicker_options
	dateEnd.datepicker datepicker_options


#”查询“订单
submit = ()->

	plateNo = plate.find("option:selected").text() + plateNum.val()
	dateStartValue = dateStart.val()
	dateEndValue = dateEnd.val()

	# console.log(indentNum + "\n" + plate + plateNum + "\n" + status + "\n" + dateStart.val() + "\n")
	if indentNum.val().length isnt 0
		plateNo = ""
		dateStartValue = ""
		dateEndValue = ""
	if plateNum.val().length is 0
		plateNo = ""


	$.get "/serve-center/order/operation/search", {
			order_id: indentNum.val(),
			car_plate_no: plateNo,
			process_status: status.find("option:selected").val(),
			start_date: dateStartValue,
			end_date: dateEndValue
		}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]
			else
				array01 = _.filter msg["orders"], "process_status", "0"
				array02 = _.filter msg["orders"], "process_status", "1"
				array03 = _.filter msg["orders"], "process_status", "2"
				array04 = _.filter msg["orders"], "process_status", "3"
				array05 = _.filter msg["orders"], "process_status", "4"

				$(".indent-tr").remove()

				if array01.length isnt 0
					html01 = _.template(template)
					html01 = html01 {
						"array": array01
					}
					tableBlank.after html01
				if array02.length isnt 0
					html02 = _.template(template)
					html02 = html02 {
						"array": array02
					}
					tableBlank.after html02
				if array03.length isnt 0
					html03 = _.template(template)
					html03 = html03 {
						"array": array03
					}
					tableBlank.after html03
				if array04.length isnt 0
					html04 = _.template(template)
					html04 = html04 {
						"array": array04
					}
					tableBlank.after html04
				if array05.length isnt 0
					html05 = _.template(template)
					html05 = html05 {
						"array": array05
					}
					tableBlank.after html05
				#显示搜索框的内容
				indentTablesWrapper.show()
				#隐藏分页按钮
				pagination.hide()


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

#取消订单
cancelDeal = (e)->
	_this = $(e.currentTarget)
	order_id = _this.attr "data-num"
	console.log order_id
	$.post "/serve-center/order/operation/cancel", {
		order_id: order_id
	}, (msg)->
		if	msg["errCode"] isnt 0
			alert msg["message"]
		else
			_this.prev().html "订单关闭"
			_this.next.hide()
			_this.hide()
		
#取消订单弹窗
cancelMaskShow = (e)->
	_this = $(e.currentTarget)
	maskBg.fadeIn(100)
	cancelMask.fadeIn(100)
	sureBtn.attr("data-num", _this.attr("data-num"))



#取消订单弹窗
refundMaskShow = ()->
	maskBg.fadeIn(100)
	refundMask.fadeIn(100)
#关闭“取消”订单弹窗
refundMaskClose = ()->
	maskBg.fadeOut(100)
	refundMask.fadeOut(100)

#申请退款
refund = (e)->
	_this = $(e.currentTarget)
	order_id = _this.attr "data-num"
	$.post "/beecloud/request-refund", {
		order_id: order_id
	}, (msg)->
		if	msg["errCode"] is 0
			_this.prev().html "退款申请中"
			_this.hide()
		else
			alert msg["message"]



#立即付款
pay = (e)->
	_this = $(e.currentTarget)
	order_id = _this.attr "data-num"
	window.location.href = "/serve-center/agency/pages/pay?order_id=" + order_id






$ ()->

	init_datepicker()
	#切换信息输入表单按钮事件绑定
	btns.on "click", cutInfoInput
	#提交”查询“订单按钮事件绑定
	submitBtn.on "click", submit
	#"取消订单"按钮弹窗事件绑定
	$(document).on "click", ".cancel-deal", cancelMaskShow
	#"取消订单"事件绑定
	$(document).on "click", ".sure-btn", cancelDeal
	#"取消订单"弹窗中的“取消”按钮时间绑定
	$(document).on "click", ".cancel-btn", closeMask
	#”申请退款“按钮事件绑定
	$(document).on "click", ".refund-btn", refund
	#"申请退款"弹窗“确定”按钮
	$(document).on "click", "#refund_btn", refundMaskClose
	#"立即付款"按钮事件绑定
	$(document).on "click", ".immediately-pay", pay










