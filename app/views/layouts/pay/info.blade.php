<div class="pay-info clearfix">
    <div class="pay-id-wrap">
        <span class="label">订单编号:</span>
        <span class="pay-id">{{{ $order->order_id }}}</span>
    </div>
    <div class="pay-amount-wrap">
    	@if( $order->trade_status == '1' )
        <span class="label">已付金额：</span>
        @else
        <span class="label">已付金额：</span>
        @endif
        <span class="pay-amount">{{{ (int)($order->capital_sum+$order->service_charge_sum+$order->express_fee) }}}</span>
    </div>
</div> 