<div class="vio-process-wrapper">
	<div class="vio-process">
		
		<div class="vio-proc-item first {{ $num >= 1 ? 'active' : ''; }}">
			<a>违章查询</a>
		</div>
		
		<img class="vio-arrow" src="/images/serve/vio_arrow.png">

		<div class="vio-proc-item {{ $num >= 2 ? 'active' : ''; }}">
			<a>违章代办</a>
		</div>
		
		<img class="vio-arrow" src="/images/serve/vio_arrow.png">

		<div class="vio-proc-item {{ $num >= 3 ? 'active' : ''; }}">
			<a>支付</a>
		</div>
		
		<img class="vio-arrow" src="/images/serve/vio_arrow.png">

		<div class="vio-proc-item last {{ $num >= 4 ? 'active' : ''; }}">
			<a>完成</a>
		</div>
		
	</div>
</div>