placeholder = require "./../../common/placeholder/placeholder.coffee"


if $.browser.msie
	if $.browser.version < 10
		alert $.browser.version 
		inputs = [
			[$(".login-content #account_num"), "邮箱"],
			[$(".login-content #password"), "密码"]
		]

		$.each inputs, (i, value)->
			placeholder.apply null, value

