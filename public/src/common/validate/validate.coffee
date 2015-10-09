###
# 定义一个验证字符串的类
# 输入需要验证的字符串
# 调用相关验证的方法
# 当返回true时表示验证通过，返回false时表示验证失败
###

class validate 

	constuctor: ()->

	#邮箱
	email: (str)->
		preg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
		return preg.test str

	#不少于六位的密码
	password: (str)->
		preg = /^[a-zA-Z0-9\_]{6,}$/
		return preg.test str

	#身份证号验证
	creditCard: (str)->
		preg = /^(\d{14}|\d{17})(\d|[xX])$/
		return preg.test str


	mobile: (str)->
		preg = /^0*(13|14|15|17|18)\d{9}$/
		return preg.test str

	phone: (str)->
		preg = /^(\d{3,4})?-?\d{7,8}(-\d{3,4})?$/
		return preg.test str

	charCodes: (str)->
		preg = /[a-zA-Z0-9]{4,}/
		return preg.test str

	engineNum: (str)->
		preg = /[a-zA-Z0-9]{4,6}/
		return preg.test str

	recordId: (str)->
		preg = /[0-9a-zA-Z]{10}|[0-9a-zA-Z]{12}/
		return preg.test str

module.exports = validate
