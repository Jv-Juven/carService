
init = (uid)->
	if(uid != "")
		console.log "自动查询..."
		params =	
			uid: uid
			startDate: moment().startOf('month').format("x")
			endDate: Number(moment().startOf('month').format("x")) + 86400 * 30 * 1000

		$.get "/admin/get-count", params, (res)->
			if(res.errCode == 0)
				console.log res
			else 
				alert res.errMsg

$startDatePicker = $("#start-date-picker");
$endDatePicker = $("#end-date-picker");

$ ()->
	uid = $("#uid").val()

	init(uid)

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

	$("#search-btn").click (e)->
		params = 
			uid: $("#uid").val()

		startDateStr = $startDatePicker.val()
		if startDateStr != ""
			params.startDate = moment(startDateStr, "YYYY-MM-DD").startOf('day').format("x")

		endDateStr = $endDatePicker.val()
		if endDateStr != ""
			params.endDate = moment(endDateStr, "YYYY-MM-DD").startOf('day').format("x")

		$.get "/admin/get-count", params, (res)->
			if(res.errCode == 0)
				console.log res
			else
				alert res.errMsg

