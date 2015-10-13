###
# 用户登录之后的页面重定向
###

redirection = (msg)->
	if msg["errCode"] is 0
		window.location.href = "/serve-center/search/pages/violation"
	else if msg["errCode"] is 10
		window.location.href = "/user/email_active"
	else if msg["errCode"] is 11
		window.location.href = "/user/info_register"
	else if msg["errCode"] is 20
		window.location.href = "/user/write-code"
	else if msg["errCode"] is 21
		window.location.href = "/user/pending"
	else if msg["errCode"] is 30
		window.location.href = "/user/lock"
	else
		alert msg["message"]


module.exports = redirection