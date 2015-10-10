
Utils = require("../../common/utils/index.coffee")

$ ()->
	$("#all").click (e)->
		pathname = window.location.pathname
		window.location.href = pathname + "?type=all"

	$("#treated").click (e)->
		pathname = window.location.pathname
		window.location.href = pathname + "?type=treated"

	$("#untreated").click (e)->
		pathname = window.location.pathname
		window.location.href = pathname + "?type=untreated"

	type = Utils.GetQueryString("type")

	$header = $("#admin-service-center-header");
	if(type == "treated")
		$($header.find("li")[2]).addClass("active")
	else if(type == "untreated")
		$($header.find("li")[1]).addClass("active")
	else
		$($header.find("li")[0]).addClass("active")


