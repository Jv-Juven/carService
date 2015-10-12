
template = _.template($("#search-result-template").html());

$ ()->
	type = "companyName";

	$("#search-btn").click ()->
		companyName = $("#company-name").val()
		licenseCode = $("#license-code").val()

		if type is "companyName"
			params = 
				companyName: companyName

		if type is "licenseCode"
			params = 
				licenseCode: licenseCode

		params.type = type;

		$.get "/admin/search-user", params, (res)->
			str = template(res)	
			$("#search-result").html(str);

	$("#company-name-select").click (e)->
		type = "companyName"
		$("#dropdown-show").html("企业名称")
		$("#company-name-wrapper").show();
		$("#license-code-wrapper").hide();

	$("#license-code-select").click (e)->
		type = "licenseCode"
		$("#dropdown-show").html("营业执照")
		$("#company-name-wrapper").hide();
		$("#license-code-wrapper").show();


