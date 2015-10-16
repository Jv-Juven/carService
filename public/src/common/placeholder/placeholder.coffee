###
# placeholder 为在不支持html5属性placeholder的浏览器下模拟html5的placeholder属性的功能
# ele 为输入框元素DOM对象
# text 为提示的信息文字
# color 为提示的信息文字的颜色
###

placeholder = (ele, text, color)->

	#判断输入框内容， 0为没有内容， 1为有内容
	tag = 0

	if !color
		color = "rgb(180, 180, 180)"

	text = text

	ele = $(ele)
	# type = ele.attr("type").toLowerCase()
	type = ele.attr("type")

	if (type isnt "text") && (type isnt "password")
		return

	placeholderText = ele.attr("placeholder") or ""

	oldColor = ele.css "color"
	
	if placeholderText isnt ""
		text = placeholderText

	ele.val text
	ele.css "color", color
	if type is "password"
		ele.attr("type", "text")

	#判断用户输入内容的长短
	ele.on "change input", ()->
		if ele.val().length > 0
			tag = 1
		else
			tag = 0

	#设置placeholder提示信息的出现的事件
	ele.on "focus", ()->
		if tag is 1
			return
		if type is "password"
			ele.attr("type", "password")
		ele.val ""
		ele.css("color", oldColor)
	ele.on "blur", ()->
		if tag is 1
			return
		if type is "password"
			ele.attr("type", "text")
		ele.val text
		ele.css("color", color)



module.exports = placeholder

