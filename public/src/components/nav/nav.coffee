nav = require "./../../common/nav/nav.coffee"

$ ()->
	pathName = document.location.pathname
	navName = pathName.split("/")[1]

	nav(navName, ".header-menu")