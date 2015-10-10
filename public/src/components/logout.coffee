logoutBtn = $("#logout_btn")


logout = ()->
	$.post "/user/logout", {}, (msg)->
		if msg["errCode"] isnt 0
			alert msg["message"]
		else
			window.location.href = "/"

logoutBtn.on "click", logout