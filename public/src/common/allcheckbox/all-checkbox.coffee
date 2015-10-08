

class AllCheckbox 

	constructor: ()->

	bindEvent: (allBtn, checkBoxes)->

		allBtn.on "chick", ()->
			if allBtn.prop("checked")
				checkBoxes.prop("checked", true)
		checkBoxes.on "click", ()->
			if $(this).prop("checked")
				tag = true
				length = checkBoxes.length
				checkBoxes.each (index, item)->
					if item.prop("checked")
						if index is (length - 1)
							allBtn.prop("checked", tag)
					else
						tag = false
						return

module.exports = AllCheckbox
				
