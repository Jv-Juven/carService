logoutBtn = $("#logout_btn")


logout = ()->
	$.post "/user/logout", {}, (msg)->
		if (msg["errCode"] is 0)|| (msg["errCode"] is 10)
			window.location.href = "/"
		else
			alert msg["errCode"]

logoutBtn.on "click", logout