
$ ()->
	$("#submit-btn").click (e)->
		username = $("#username").val()
		password = $("#password").val()

		params = 
			username: username
			password: password

		$.post "/admin/login", params, (res)->
			if(res.errCode == 0)
				alert "登录成功"
				window.location.href = "/admin/business-center/new-user-list"
			else
				alert res.errMsg
