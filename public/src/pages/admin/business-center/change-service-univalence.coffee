$ ()->
	$("#submit-btn").click ()->
		userId = $("#user-id").val()
		expressUnivalence = $("#express-univalence").val()
		agencyUnivalence = $("#agency-univalence").val()

		params = {userId: userId};
		if(expressUnivalence)
			params.expressUnivalence = expressUnivalence
		if(agencyUnivalence)
			params.agencyUnivalence = agencyUnivalence

		$.post "/admin/change-service-univalence", params, (res)->
			if(res.errCode == 0) 
				alert '修改成功'
			else 
				alert res.errMsg
