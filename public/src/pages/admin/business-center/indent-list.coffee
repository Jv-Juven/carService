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
			$td = $elem.parent()
			indentId = $td.find(".indent-id").val()

			$.post "/admin/change-indent-status", {status: 2, indentId: indentId}, (res)->
				if res.errCode == 0
					$elem.hide()
					$td.parent().parent().find("." + indentId + " .process-status").html("办理中")
					$td.find(".finished-btn").show()
				else
					alert res.errMsg

	$(".finished-btn").click (e)->
		if confirm("该订单状态将变更为[已办理]")
			$elem = $(e.currentTarget)
			$td = $elem.parent()
			indentId = $td.find(".indent-id").val()

			$.post "/admin/change-indent-status", {status: 3, indentId: indentId}, (res)->
				if res.errCode == 0
					$elem.hide()
					$td.parent().parent().find("." + indentId + " .process-status").html("已完成")
				else
					alert res.errMsg




