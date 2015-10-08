LeftNav = require "./../../../common/leftnav/index.coffee"

$(document).ready ()->
	pathname = document.location.pathname
	subNav = pathname.split("/")[4]

	leftNav = new LeftNav(subNav, "#serve-left-nav", "serveCenter")


