###
# placeholder 为在不支持html5属性placeholder的浏览器下模拟html5的placeholder属性的功能
# ele 为输入框元素DOM对象
# text 为提示的信息文字
# color 为提示的信息文字的颜色
###

placeholder = (ele, text, color)->

	if !color
		color = "rgb(180, 180, 180)"

	text = text

	ele = $(ele)
	type = ele.attr("type").toLowerCase()

	if (type isnt "text") or (type isnt "password")
		return

	placeholderText = ele.attr("placeholder") or ""
	oldColor = ele.css "color"

	if placeholderText isnt ""
		text = placeholderText

	alert text
	
	ele.val text


	#设置placeholder提示信息的出现的事件
	ele.on "focus", ()->
		ele.val ""
		ele.css("color", oldColor)
	ele.on "blur", ()->
		ele.val text
		ele.css("color", color)



module.exports = placeholder

