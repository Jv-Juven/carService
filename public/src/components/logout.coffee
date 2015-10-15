logoutBtn = $("#logout_btn")


logout = ()->
	$.post "/user/logout", {}, (msg)->
		console.log msg
		if (msg["errCode"] is 0)|| (msg["errCode"] is 10)
			console.log msg["errCode"]
			window.location.href = "/"
		else
			alert msg["errCode"]
	.error (xhr, errorText, errorType)->
		alert "提交失败，请重试"

logoutBtn.on "click", logout