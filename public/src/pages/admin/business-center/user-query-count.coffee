

parseDataForHighCharts = (data)->
	result = {
		"violation": [],
		"license": [],
		"car": []
	}
	for i in [0 ... data.length]
		name = data[i].type
		date = new Date(data[i].date).getTime() + 3600 * 8 * 1000
		item = [date, data[i].value]

		result[name].push item

	result['violation'].sort (a, b)->
		if a[0] < b[0]
			return -1;
		else 
			return 1;

	results = [{
		name: '违章查询',
		data: result["violation"]
	}, {
		name: '驾驶证查询',
		data: result["license"]
	}, {
		name: '机动车查询',
		data: result["car"]
	}]

	return results;

initHighCharts = (selector, data)->
	series = parseDataForHighCharts data
	console.log series
	options = {
		title:{
			text: '用户查询次数统计'
		},
		xAxis: {
			type: 'datetime',
			dateTimeLabelFormats: {
				day: '%e/%b',
				week: '%e. %b',
				month: '%b %y',
				year: '%Y'
			},
			tickInterval: 86400000
		},
		yAxis: {
			title: {
				text: '查询次数'
			},
			min: 0
		},
		tooltip: {
			formatter: ()->
				return '<b>'+ this.series.name + '</b><br>' +
					Highcharts.dateFormat('%Y-%b-%e', this.x) + ': ' + this.y + ' 次';
		},
		series: series
	}

	$(selector).highcharts options

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
				initHighCharts "#search-result", res.data
			else
				alert res.errMsg

