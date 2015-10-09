$ ()->
	$("#submit-btn").click ()->
		remarkCode = $("#remark-code").val()
		userId = $("#user-id").val()

		params = 
			userId: userId
			remarkCode: remarkCode

		$.post "/admin/set-remark-code", params, (res)->
			if(res.errCode == 0) 
				alert '修改成功'
			else 
				alert res.errMsg
