
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

	# console.log(indentNum + "\n" + plate + plateNum + "\n" + status + "\n" + dateStart.val() + "\n" + )

	$.get "/serve-center/order/operation/searchs", {
			order_id: indentNum,
			car_plate_no: plate + plateNum,
			process_status: status,
			start_date: dateStart.val(),
			end_date: dateEnd.val()
		}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]
			else
				
				array01 = _.filter msg["orders"], "process_status", "0"
				array02 = _.filter msg["orders"], "process_status", "1"
				array03 = _.filter msg["orders"], "process_status", "2"
				array04 = _.filter msg["orders"], "process_status", "3"
				array05 = _.filter msg["orders"], "process_status", "4"

				html01 = _.template(template)
				html02 = _.template(template)
				html03 = _.template(template)
				html04 = _.template(template)
				html05 = _.template(template)

				tableBlank.after html01({
					"array": array01
					})
				tableBlank.after html02({
					"array": array02
					})
				tableBlank.after html03({
					"array": array03
					})
				tableBlank.after html04({
					"array": array04
					})
				tableBlank.after html05({
					"array": array05
					})
				#显示搜索框的内容
				indentTablesWrapper.show()


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
cancelMaskShow = ()->
	maskBg.fadeIn(100)
	cancelMask.fadeIn(100)

#取消订单弹窗
refundMaskShow = ()->
	maskBg.fadeIn(100)
	refundMask.fadeIn(100)

#申请退款
refund = (e)->
	_this = $(e.currentTarget)
	order_id = _this.attr "data-num"
	$.post "/serve-center/order/operation/refund", {
		order_id: order_id
	}, (msg)->
		if	msg["errCode"] isnt 0
			alert msg["message"]
		else
			_this.prev().html "退款申请中"
			_this.hide()





$ ()->

	init_datepicker()
	#切换信息输入表单按钮事件绑定
	btns.on "click", cutInfoInput
	#提交”查询“订单按钮事件绑定
	submitBtn.on "click", submit
	#"取消订单"按钮弹窗事件绑定
	cancelDealBtn.on "click", cancelMaskShow
	#"取消订单"事件绑定
	sureBtn.on "click", cancelDeal
	#"取消订单"弹窗中的“取消”按钮时间绑定
	cancelBtn.on "click", closeMask
	#”申请退款“按钮事件绑定
	refundBtn.on "click", refund










