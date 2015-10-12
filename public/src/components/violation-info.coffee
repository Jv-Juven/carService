#账户余额
infoBalance = $("#info_balance")
#剩余查询次数
infoTimes = $("#info_times")


#数据填充
fillData = (balance, times)->
	infoBalance.text balance
	infoTimes.text infoTimes

module.exports = fillData