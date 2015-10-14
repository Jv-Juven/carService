payWechatBtn = $("#pay_wechat")
payPaypalBtn = $("#pay_paypal")
orderId = $("#order-id")
payMask = $(".pay-mask")
completeBtn = $(".complete-btn")
questionBtn = $(".question-btn")


#微信支付
payWechat = ()->
	$.post "/beeclound/order-agency", {
		order_id: orderId.val()
	}, (msg)->
		if msg["errCode"] is 0
			payMask.fadeIn(100)
			window.open( msg['url'] )
		else
			alert msg["message"]

#完成支付
complete = ()->
	$.get "/serve-center/order/order-trade-status", {
			order_id: order_id.val()
		}, (msg)->
			if msg["errCode"] is 0
				if msg["trade_status"] is 0
					window.location.href = ""
				else
					window.location.href = ""
			else
				alert ["message"]


#支付遇到问题
question = ()->
	window.open("")


$ ()->
	#“微信支付”按钮事件绑定
	payWechatBtn.on "click", payWechat
	#"完成支付"按钮事件绑定
	completeBtn.on "click", complete
	#“支付遇到问题”按钮事件绑定
	questionBtn.on "click", question
