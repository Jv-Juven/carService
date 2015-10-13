
init = (appkey)->
	if(appkey != "")
		console.log "自动查询..."
		params =	
			appkey: appkey

		$.post "/admin/get-count", params, (res)->
			if(res.errCode == 0)
				alert "查询成功"
			else 
				alert res.errMsg

$startDatePicker = $("#start-date-picker");
$endDatePicker = $("#end-date-picker");

$ ()->
	console.log "enter page"
	appkey = $("#appkey").val()

	init(appkey)

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
		startDate = moment($startDatePicker.val(), "YYYY-MM-DD").startOf('day').format("x")
		endDate = moment($endDatePicker.val(), "YYYY-MM-DD").startOf('day').format("x")

		params = 
			appkey: appkey
			endDate: endDate
			startDate: startDate

		$.get "/admin/get-count", params, (res)->
			if(res.errCode == 0)
				alert "查询成功"
			else
				alert res.errMsg

