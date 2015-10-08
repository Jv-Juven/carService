$ ()->
	$("#submit-btn").click ()->
		expressUnivalence = $("#express-univalence").val()
		agencyUnivalence = $("#agency-univalence").val()

		params = 
			expressUnivalence: expressUnivalence
			agencyUnivalence: agencyUnivalence

		$.post "/admin/change-default-service-univalence", params, (res)->
			if(res.errCode == 0) 
				alert '修改成功'
			else 
				alert '修改失败'
