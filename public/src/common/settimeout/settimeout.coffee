###
# 计时器
# ele为计时数字容器
# count为计时数
###

settimeout = (ele, count, callback)->
	
	#计时开始执行的函数
	ele.addClass("btn-disabled").off()

	oldText = ele.text()

	start = 0
	ele.text(start + "后重发")
	timeout = setInterval ()->
		if start is count
			clearTimeout timeout
			#计时完成后执行的回调函数
			ele.removeClass("btn-disabled")
			callback()
			ele.text oldText
			return
		start += 1
		ele.text(start + "秒后重发")
	,1000



module.exports = settimeout



