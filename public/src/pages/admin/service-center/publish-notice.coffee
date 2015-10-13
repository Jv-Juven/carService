
$ ()->
	
	$titleInput = $("#title");
	$contentInput = $("#content");

	$("#submit-btn").click (e)->
		title = $titleInput.val();
		content = $contentInput.val();

		params = 
			title: title
			content: content

		$.post "/admin/publish-notice", params, (res)->
			if res.errCode is 0
				alert "发布成功"
				window.location.href = "/admin/service-center/notice-list"
			else
				alert res.errMsg
