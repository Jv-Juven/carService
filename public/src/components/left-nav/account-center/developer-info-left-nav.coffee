LeftNav = require "./../../../common/leftnav/index.coffee"

$(document).ready ()->
	pathname = document.location.pathname
	subNav = pathname.split("/")[2]

	leftNav = new LeftNav(subNav, "#account-center-left-nav", "accountCenter")


