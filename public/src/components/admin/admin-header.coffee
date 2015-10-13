$ ()->
	pathname = document.location.pathname

	target = pathname.split("/")[2];

	if(target == "business-center")
		index = 0;
	else if (target == "service-center")
		index  = 1
	else if(target == "admin-account") 
		index = 3;

	if(index != undefined)
		nav = $("#admin-header").find(".nav").find("li").removeClass("active");
		$(nav[index]).addClass("active");

	$("#logout").click ()->
		$.post "/admin/logout", {}, (res)->
			if res.errCode == 0
				alert "退出成功！"
				window.location.href = "/admin/login"