provinceConfig = require("../../../common/config/provinceABBR.coffee")

$startDatePicker = $("#start-date-picker");
$endDatePicker = $("#end-date-picker");
$provinceDropdownShow = $("#province-dropdown-show");
$statusDropdownShow = $("#status-dropdown-show");
$resultContainer = $("#search-result")

statusSelectTemplate = _.template($("#status-select-template").html())
searchResultTemplate = _.template($("#search-result-template").html())
provinceSelectTemplate = _.template($("#province-select-template").html())

init = ()->
	$provinceDropdownMenu = $(".province-dropdown-menu");
	for i in [0 ... 10]
		$provinceDropdownMenu.append($(provinceSelectTemplate({name: provinceConfig[i].name, pinyin: provinceConfig[i].pinyin})));

$ ()->
	init()

	$('.form-date').datetimepicker({
		language:  'fr',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
	});

	global = {
		status: "all",
		province: "粤"
	};

	$(document).on "click", ".status-select", (e)->
		$elem = $(e.currentTarget)
		global.status = $elem.attr("data-name");
		$statusDropdownShow.html $elem.html()

	$(document).on "click", ".province-select", (e)->
		$elem = $(e.currentTarget)
		global.city = $elem.attr("data-name");
		$provinceDropdownShow.html $elem.html()

	$("#search-by-id-btn").click (e)->
		indentId = $("#indent-id").val()
		type = $("#type").val()

		params = 
			type: type
			indentId: indentId

		$.get "/admin/indents", params, (res)->
			indents = res.indents

			if(indents.length == 0)
				return $resultContainer.html "您搜索的查询结果未找到任何数据"
			console.log indents.length


	$("#search-by-info-btn").click (e)->
		startDate = moment($startDatePicker.val(), "YYYY-MM-DD")
		startDatestr = startDate.format("YYYY-MM-DD") + " 00:00:00"
		startDateSec = startDate.format("X");
		endDate = moment($endDatePicker.val(), "YYYY-MM-DD")
		endDateStr = endDate.format("YYYY-MM-DD") + " 00:00:00"
		endDateSec = endDate.format("X")

		licensePlate = $("#license-plate").val()
		type = $("#type").val()

		if(startDateSec > endDateSec)
			return alert "结束时间不能小于开始时间"

		params = 
			licensePlate: global.province + licensePlate
			startDate: startDatestr
			endDate: endDateStr
			status: global.status
			type: type

		$.get "/admin/indents", params, (res)->
			indents = res.indents

			if(indents.length == 0)
				return $resultContainer.html "您搜索的查询结果未找到任何数据"

			$resultContainer.html searchResultTemplate(res)






