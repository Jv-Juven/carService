placeholder = require "./../../common/placeholder/placeholder.coffee"

inputs = [
	[".login-content #account_num", "邮箱"],
	[".login-content #password", "密码"]
]

$.each inputs, (i, value)->
	console.log value
	placeholder.apply null, value

# if $.browser.msie
# 	if $.browser.version < 10
# 		console.log $.browser.version


