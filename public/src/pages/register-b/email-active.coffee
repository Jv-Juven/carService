resendBtn = $(".email-resend")

#重新发送邮件
resend = ()->
	$.post "/user/send_token_to_email", {}, (msg)->
		if msg["errCode"] isnt 0
			alert msg["message"]
		else
			alert "邮件发送成功"


$ ()->
	resendBtn.on "click", resend
		