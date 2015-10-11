
$ ()->
	
	global =
		status: 1

	$(document).on "click", ".dropdown-select", (e)->
		$elem = $(e.currentTarget)
		global.status = $elem.attr("data-name");

		$("#dropdown-show").html $elem.html()

	$("#submit-btn").click (e)->
		indentId = $("#indent-id").val()

		params =
			status: global.status
			indentId: indentId

		$.post "/admin/change-refund-status", params, (res)->
			if(res.errCode == 0)
				window.location.href = "/admin/business-center/refund-indent-info?indent_id=" + indentId
			else 
				alert res.errMsg

