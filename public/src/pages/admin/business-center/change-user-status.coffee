statusName = null

statusCode = 
	"active-select": 22,
	"unactive-select": 21,
	"unchecked-select": 20,
	"lock-select": 30

statusIntro = 
	"active-select": "企业用户的账号状态正常，可正常使用车务服务系统的所有服务",
	"unactive-select": "等待用户回填校验码之后激活账号，在此之前该用户无法进行任何操作",
	"unchecked-select": "用户信息待审核，该用户无法进行任何操作",
	"lock-select": "账号被锁定，该用户将无法进行任何操作"

$ ()->
	$(".dropdown-item").click (e)->
		$elem = $(e.currentTarget)
		statusName = $elem.attr("data-name");

		$("#status-name").html $elem.html()
		$("#status-intro").html statusIntro[statusName]

	$("#info-btn").click ()->
		userId = $("#user-id").val()
		window.location.href = "/admin/business-center/user-info?user_id=" + userId

	$("#submit-btn").click ()->
		userId = $("#user-id").val()

		if not statusName
			return alert "[错误信息]请先选择要更改的状态"

		params = 
			status: statusCode[statusName]
			userId: userId

		$.post "/admin/change-user-status", params, (res)->
			if(res.errCode == 0)
				alert "修改成功"
			else 
				alert res.errMsg
