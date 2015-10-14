payWechatBtn = $("#pay_wechat")
payPaypalBtn = $("#pay_paypal")
orderId =$("#order-id")


#微信支付
payWechat = ()->
	$.post "/beeclound/order-agency", {
		order_id: orderId
	}, (msg)->
		if msg["errCode"] is 0
			window.open( msg['url'] )
		else
			alert msg["message"]

$ ()->
	#“微信支付”按钮事件绑定
	payWechatBtn.on "click", payWechat
