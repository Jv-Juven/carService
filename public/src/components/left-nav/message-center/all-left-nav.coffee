LeftNav = require "./../../../common/leftnav/index.coffee"

$(document).ready ()->
	pathname = document.location.pathname
	subNav = pathname.split("/")[3]

	leftNav = new LeftNav(subNav, "#messge-left-nav", "messageCenter")


