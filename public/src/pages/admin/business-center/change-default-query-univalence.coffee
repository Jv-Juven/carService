$ ()->
	$("#submit-btn").click ()->
		violationUnivalence = $("#violation-univalence").val()
		licenseUnivalence = $("#license-univalence").val()
		carUnivalence = $("#car-univalence").val()

		if(!violationUnivalence || !licenseUnivalence || !carUnivalence)
			return alert("请勿留空");

		params = 
			violationUnivalence: violationUnivalence
			licenseUnivalence: licenseUnivalence
			carUnivalence: carUnivalence

		$.post "/admin/change-default-query-univalence", params, (res)->
			if(res.errCode == 0) 
				alert '修改成功'
			else 
				alert '修改失败'
