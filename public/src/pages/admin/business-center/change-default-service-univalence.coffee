$ ()->
	$("#submit-btn").click ()->
		companyExpressUnivalence = $("#company-express-univalence").val()
		personExpressUnivalence = $("#person-express-univalence").val()
		companyAgencyUnivalence = $("#company-agency-univalence").val()
		personAgencyUnivalence = $("#person-agency-univalence").val()

		if(!companyExpressUnivalence || !personAgencyUnivalence || !companyAgencyUnivalence || !personExpressUnivalence)
			return alert("请勿留空");

		params = 
			companyExpressUnivalence: companyExpressUnivalence
			personExpressUnivalence: personExpressUnivalence
			companyAgencyUnivalence: companyAgencyUnivalence
			personAgencyUnivalence: personAgencyUnivalence

		$.post "/admin/change-default-service-univalence", params, (res)->
			if(res.errCode == 0) 
				alert '修改成功'
			else 
				alert res.errMsg
