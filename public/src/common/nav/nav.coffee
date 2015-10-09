config = require "./nav-config.coffee"

nav =  (navName, id)->
	nav = $ id
	index = config[navName]
	navItems = nav.find(".nav-item")
	navItems.remove("active").eq(index).addClass "active"

module.exports = nav
