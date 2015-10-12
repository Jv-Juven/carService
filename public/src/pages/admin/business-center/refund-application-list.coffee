Utils = require("../../../common/utils/index.coffee")

$ ()->
	type = Utils.GetQueryString("type")
	$header = $("#admin-business-center-refund-application-list-header");
	if(type == "approving")
		$($header.find("li")[1]).addClass("active")
	else if(type == "pass")
		$($header.find("li")[2]).addClass("active")
	else if(type == "unpass")
		$($header.find("li")[3]).addClass("active")
	else
		$($header.find("li")[0]).addClass("active")