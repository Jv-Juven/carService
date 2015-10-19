resendBtn = $(".email-resend")
backBtn = $(".email-back")#重写填写 按钮

#重新发送邮件
resend = ()->
	$.post "/user/send_token_to_email", {}, (msg)->
		if msg["errCode"] isnt 0
			alert msg["message"]
		else
			alert "邮件发送成功"
#返回重新填写
back = ()->
	$.post "/user/re-write-info", {}, (msg)->
		if (msg["errCode"] is 0) or (msg["errCode"] is 10)
			window.location.href = "/user/b_register?v=" + Math.random()
		else
			alert msg["errCode"]


$ ()->

	#重发验证码
	resendBtn.on "click", resend
	#返回重新填写
	backBtn.on "click", back
		