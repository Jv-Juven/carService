logoutBtn = $("#logout_btn")


logout = ()->
	$.post "/user/logout", {}, (msg)->
		if (msg["errCode"] is 0)|| (msg["errCode"] is 10) || (msg["errCode"] is 1)
			window.location.href = "/"
		else
			alert msg["message"]
	.error (xhr, errorText, errorType)->
		alert "提交失败，请重试"

logoutBtn.on "click", logout