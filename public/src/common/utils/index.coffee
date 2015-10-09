
Utils = 
	GetQueryString: (name)->
		reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)")
		r = window.location.search.substr(1).match(reg)
		if(r!=null)
			return  unescape(r[2]); 
		return null

module.exports = Utils