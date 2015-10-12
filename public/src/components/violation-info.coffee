#账户余额
infoBalance = $("#info_balance")
#剩余查询次数
infoTimes = $("#info_times")


#数据填充
info = {

	fillData = (balance, unit)->
		times = parseInt(balance) / parseInt(unit)

		infoBalance.text balance
		infoTimes.text times
	fillTimes = (times)->
		infoTimes.text times
}

module.exports = info