Utils = require("../../../common/utils/index.coffee")

$ ()->
	type = Utils.GetQueryString("type")

	$navs = $("#admin-business-center-user-list-header").find("li").removeClass("active")

	if(type == "actived")
		$($navs[1]).addClass("active")
	else if(type == "unactived")
		$($navs[2]).addClass("active")
	else if(type == "unchecked")
		$($navs[3]).addClass("active")
	else if(type == "locked")
		$($navs[4]).addClass("active")
	else if(type == "others")
		$($navs[5]).addClass("active")
	else 
		$($navs[0]).addClass("active")

