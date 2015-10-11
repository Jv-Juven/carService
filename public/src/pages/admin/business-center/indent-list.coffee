Utils = require("../../../common/utils/index.coffee")

$ ()->
	type = Utils.GetQueryString("type")

	$header = $("#admin-business-center-indent-list-header");
	if(type == "treated")
		$($header.find("li")[2]).addClass("active")
	else if(type == "untreated")
		$($header.find("li")[1]).addClass("active")
	else if(type == "treating")
		$($header.find("li")[3]).addClass("active")
	else if(type == "finished")
		$($header.find("li")[4]).addClass("active")
	else if(type == "closed")
		$($header.find("li")[5]).addClass("active")
	else
		$($header.find("li")[0]).addClass("active")

	$(".treating-btn").click (e)->
		if confirm("该订单状态将变更为[办理中]，请及时处理该订单！")
			$elem = $(e.currentTarget)
			indentId = $elem.parent().parent().parent().find(".indent-id").val()

			$.post "/admin/change-indent-status", {status: 2, indentId: indentId}, (res)->
				$elem.addClass("disabled")
