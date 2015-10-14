#账户余额
infoBalance = $("#info_balance")
#剩余查询次数
infoTimes = $("#info_times")


#数据填充
info = {

	fillData: (balance, unit)->
		times = balance / unit

		infoBalance.text balance
		infoTimes.text parseInt(times)
	fillTimes: (times)->
		infoTimes.text parseInt(times)
}

module.exports = info