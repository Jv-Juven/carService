
showUploadFileName = (ele, name)->
	ele.attr({"type": "text", "readOnly": "true"}).val(name).addClass("file-name-show")

module.exports = showUploadFileName