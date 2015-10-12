$ ()->
	$(".treat-btn").click (e)->
		$elem = $(e.currentTarget)
		$parent = $elem.parent().parent()
		feedbackId = $parent.find(".feedback-id").val()

		if(!confirm("确认已处理用户反馈的问题？"))
			return false;

		$.post "/admin/feedback", {feedbackId: feedbackId}, (res)->
			if(res.errCode == 0)
				$parent.find(".status").html "已处理"
				$parent.find(".operation").html '<button type="button" class="btn btn-success disabled">已处理</button>'
			else
				alert res.errMsg