

class AllCheckbox 

	constructor: ()->

	bindEvent: (allBtn, checkBoxes)->

		allBtn.on "click", ()->
			if allBtn.prop("checked")
				checkBoxes.prop("checked", true)
			else
				checkBoxes.prop("checked", false)
		checkBoxes.on "click", ()->
			if $(this).prop("checked")
				tag = true
				length = checkBoxes.length
				checkBoxes.each (index, item)->
					item = $(item)
					if item.prop("checked")
						if index is (length - 1)
							allBtn.prop("checked", tag)
					else
						tag = false
						return
			else
				allBtn.prop("checked", false)

module.exports = AllCheckbox
				
