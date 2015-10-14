codesInput = $(".write-codes-input")
warnTips = $(".warn-tips")
submitBtn = $(".write-codes-submit-btn")

submit = ()->
	if !/[\d]{6}/.test(codesInput.val())
		warnTips.text "*请填写6位的打款备注码"
		return
	warnTips.text " "

	$.post "/user/money_remark_code", {
		remark_code: codesInput.val()
		},(msg)->
			if msg["errCode"] is 0
				window.location.href = "/serve-center/search/pages/violation"
			else if msg["errCode"] is 30
				window.location.href = "/user/lock"
			else
				alert msg["message"]
	.error (xhr,errorText,errorType)->
		alert "提交失败，请重试"		


$ ()->
	submitBtn.on "click", submit
