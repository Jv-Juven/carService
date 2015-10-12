
$ ()->

	$("#new-password-confirm").keydown (e)->
		if(e.keyCode == 13)
			$("#submit-btn").click()
	
	$("#submit-btn").click (e)->
		adminId = $("#admin-id").val()
		username = $("#username").val()	
		oldPassword = $("#old-password").val()
		newPassword = $("#new-password").val()
		newPasswordConfirm = $("#new-password-confirm").val()

		if(oldPassword == "" || newPassword == "" || newPasswordConfirm == "")
			return alert "请勿留空！"

		params =
			adminId: adminId
			username: username
			oldPassword: oldPassword
			newPassword: newPassword
			newPasswordConfirm: newPasswordConfirm

		$.post "/admin/change-password", params, (res)->
			if(res.errCode == 0)
				alert "修改成功"
				window.location.href = "/admin/account/change-password"
			else
				alert res.errMsg