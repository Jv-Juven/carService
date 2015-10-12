<div class="violation-info">
    @if ( array_key_exists( 'unit', $account ) )
	<div class="info-tr">
		<div class="info-title">账户余额</div>
		<div class="info-num" id="info_balance">{{{ $account['balance'] }}}</div>
	</div>
    @endif
	<div class="info-tr">
		<div class="info-title">剩余查询次数</div>
		<div class="info-num" id="info_times">{{{ $account['balance'] / $account['unit'] }}}</div>
	</div>
</div>