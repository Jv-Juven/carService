
$ ()->
	$("#password").keydown (e)->
		if(e.keyCode == 13)
			$("#submit-btn").click();

	$("#submit-btn").click (e)->
		username = $("#username").val()
		password = $("#password").val()

		params = 
			username: username
			password: password

		$.post "/admin/login", params, (res)->
			if(res.errCode == 0)
				window.location.href = "/admin/business-center/new-user-list"
			else
				alert res.errMsg
