codesInput = $(".write-codes-input")
warnTips = $(".warn-tips")
submitBtn = $(".write-codes-submit-btn")

submit = ()->
	if codesInput.val().length is 0
		warnTips.text "*请填写打款备注码"
		return
	warnTips.text " "

	$.post "/user/money_remark_code", {
		remark_code: codesInput.val()
		},(msg)->
			if msg["errCode"] isnt 0
				alert msg["message"]			
			else
				window.location.href = "/serve-center/search/pages/violation"


$ ()->
	submitBtn.on "click", submit
