

###
# 替换字符串函数
# str,要替换的字符串，begin替换起始位置,end替换结束位置,char替代查找到的字符串
###

strMask = (str,begin,end,char)->
	fstStr = str.substring 0,begin
	scdStr =str.substring begin,end
	lstStr = str.substring end,str.length
	matchExp = /[\w\d]/g;
	return (fstStr + scdStr.replace(matchExp,char) + lstStr)


module.exports = strMask
