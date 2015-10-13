
_wx_pay_btn = null
_ali_pay_btn = null

post_pay = ( money, channel ) ->

    $.post '/beeclound/recharge', {
        money: money,
        channel: channel
    }, ( result ) ->
        if result['errCode'] is 0
            window.open( result['url'] )
        else
            alert result['message']

$ -> 
    _wx_pay_btn = $ '#pay-wx'
    _ali_pay_btn = $ '#pay-ali'

    _wx_pay_btn.on 'click', ( event )->
        post_pay( $('#amount-input').val(), 'WX' )

    _ali_pay_btn.on 'click', ( event )->
        alert '暂不支持支付宝支付'
        # post_pay( $('#amount-input').val(), 'ALI' )

