config = require "./nav-config.coffee"

class LeftNav 
	constructor: (nav, selector, module)->
		$leftNav = $(selector)

		if $leftNav.length == 0
			return 

		$subNavs = $leftNav.find(".sub-nav").find("li")
		$navs = $leftNav.find(".nav-item")

		if !config[module]?
			return 

		targetSubNav = $subNavs[config[module].subNavIndexes[nav]];
		$(targetSubNav).addClass("active")

		targetNav = $navs[config[module].navIndexes[nav]]
		$(targetNav).parent().addClass("active")
		$(targetNav).parent().find(".sub-nav").slideDown()

		$navItem = $leftNav.find ".nav-a" 
		$navItem.click (e)->
			$target = $ e.currentTarget

			$navItem.each (index, item)->
				$item = $(item)
				$parent = $item.parent()
				if $parent.hasClass("active")
					$parent.removeClass "active"
					$parent.find(".sub-nav").slideUp()

			$parent = $target.parent()
			$parent.find(".sub-nav").slideToggle()
			$parent.addClass "active"

module.exports = LeftNav