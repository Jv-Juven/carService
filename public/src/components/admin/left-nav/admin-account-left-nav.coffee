LeftNav = require "../../../common/leftnav/index.coffee"

$(document).ready ()->
	pathname = document.location.pathname

	nav = pathname.split("/")[3];

	leftNav = new LeftNav(nav, "#admin-account-left-nav", "adminAccount")	