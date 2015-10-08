

class AllCheckbox 

	constructor: (@allBtn, @checkBoxes)->
		bindEvnet(@allBtn, @checkBoxes)

	bindEvnet: (allBtn, checkBoxes)->

		allBtn.on "chick", ()->
			if allBtn.prop("checked")
				checkBoxes.prop("checked", true)
		checkBoxes.on "click", ()->
			if $(this).prop("checked")
				tag = true
				checkBoxes.each (item, index)->
					if item.prop("checked")
						continue
					else
						tag = false
						break
				allBtn.prop("checked", tag)
