#########
# 基于jQuery类库
# 需要引入warn-mask文件
# 在页面里加上 @include("components.warn-mask")引入警告框的HTML文件
# 参数说明：
# text 为提示语，是给展现给用户的提示语
# bg 为浮层的背景jQuery对象
# box 为提示语的父容器jQuery对象
#########

class Warn

	constuctor: ()->

	alert: (text, bg, box)->
		if !bg
			bg = $(".mask, #mask")
		if !box
			box = $("#common_wran_msg")
		bg.fadeIn(200)
		box.text(text).fadeIn(200)

module.exports = Warn