<div class="pay-info clearfix">
    <div class="pay-id-wrap">
        <span class="label">订单编号:</span>
        <span class="pay-id">{{{ $order->order_id }}}</span>
    </div>
    <div class="pay-amount-wrap">
        <span class="label">订单金额：</span>
        <span class="pay-amount">{{{ (int)($order->capital_sum+$order->service_charge_sum+$order->express_fee) }}}元</span>
    </div>
</div> 