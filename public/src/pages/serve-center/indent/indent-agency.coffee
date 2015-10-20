
indentNum = $("#indent-number")
plate = $(".inputs-container-tabs02").find("select").eq(0)
plateNum = $("#indent_agency_plate_num")

#违章城市
city = $(".indent-city")
#业务状态
status = $(".indent-status")

dateStart = $("#indent_date_start")
dateEnd = $("#indent_date_end")


btns = $(".indent-menu-btns .btn")

tableBlank = $(".table-blank")

tabs01 = $(".inputs-container-tabs01")
tabs02 = $(".inputs-container-tabs02")

submitBtn = $(".indent-submit")

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

noResulte = $(".indent-no-resulte")

#查询类型的标志
queryType = 0

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

	#显示与隐藏初始化，隐藏分页按钮
	$(".paginate-wrap").hide()

	order_id = indentNum.val()
	plateNo = plate.find("option:selected").text() + plateNum.val()
	process_status = status.find("option:selected").val()
	dateStartValue = dateStart.val()
	dateEndValue = dateEnd.val()

	#根据查询类型的不同传入不同的值
	if queryType is 0
		plateNo = ""
		dateStartValue = ""
		dateEndValue = ""
	else
		plateNo = ""


	#查询请求后端的数据
	$.get "/serve-center/order/operation/search", {
			order_id: order_id,
			car_plate_no: plateNo,
			process_status: process_status,
			start_date: dateStartValue,
			end_date: dateEndValue
		}, (msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]
			else

				#显示与隐藏初始化
				$(".indent-tables-wrapper").hide()
				noResulte.hide()

				if msg["orders"].length is 0
					noResulte.show()
					return
				
				array01 = msg["orders"]

				$(".indent-tr").remove()

				if array01.length isnt 0
					html01 = _.template(template)
					html01 = html01 {
						"array": array01
					}
					tableBlank.after html01
					
				#显示搜索框的内容
				$(".indent-tables-wrapper").show()
				


#切换信息填写
cutInfoInput = (e)->
	_this = $(e.currentTarget)
	if _this.hasClass "active"
		return
	_this.addClass("active").siblings().removeClass("active")
	_index = _this.index()
	if _index is 0
		queryType = 0
		tabs02.hide()
		tabs01.show()
	else
		queryType = 1
		indentNum.val("")
		tabs01.hide()
		tabs02.show()

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
			# _this.prev().html "订单关闭"
			# _this.next().hide()
			alert msg["message"]
			location.reload()
		
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

	#当订单记录为空的时候，隐藏表格
	if $(".indent-tr").length is 0
		$(".indent-tables-wrapper").hide()
		noResulte.show()
		$(".paginate-wrap").hide()










