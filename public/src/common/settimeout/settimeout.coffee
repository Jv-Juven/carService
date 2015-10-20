###
# 计时器
# ele为计时数字容器
# count为计时数
###

settimeout = (ele, count, callback, btnText)->
	
	#计时开始执行的函数
	ele.addClass("btn-disabled").off()
	if !(btnText.length > 0)
		oldText = ele.text()
	else
		oldText = btnText

	start = count
	ele.text(start + "后重发")
	timeout = setInterval ()->
		if start is 1
			clearTimeout timeout
			#计时完成后执行的回调函数
			ele.removeClass("btn-disabled")
			ele.text oldText
			callback()
			return
		start -= 1
		ele.text(start + "秒后重发")
	,1000



module.exports = settimeout



