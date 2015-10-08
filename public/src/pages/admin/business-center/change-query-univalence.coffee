$ ()->
	$("#submit-btn").click ()->
		violationUnivalence = $("#violation-univalence").val()
		licenseUnivalence = $("#license-univalence").val()
		carUnivalence = $("#car-univalence").val()
		userId = $("#user-id").val();

		params = {}
		if(violationUnivalence != "")
			params.violation = violationUnivalence
		if(licenseUnivalence != "")
			params.license = licenseUnivalence
		if(carUnivalence != "")
			params.car = carUnivalence

		$.post "/admin/change-query-univalence", {params: params, userId: userId}, (res)->
			if(res.errCode == 0) 
				alert '修改成功'
				for name of params
					$("#" + name + "-univalence-show").html params[name]
					$("#" + name + "-univalence").val ""

			else 
				alert '修改失败'
