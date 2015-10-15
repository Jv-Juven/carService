@extends("layouts.submaster")



@section("css")
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/serve-center/business/violation.css">
@stop

@section("left-nav")
	@include("components.left-nav.serve-left-nav")
@stop

@section("right-content")
    @if ( isset( $account ) )
	    @include("components.violation", [ 'account' => $account ])
    @else
        @include("components.violation")
    @endif
    
	@include("components.log-reg-mask")
@stop
@section("js")
	@parent
	<script type="text/javascript" src="/lib/js/lodash.min.js"></script>
	<script type="text/javascript" src="/dist/js/pages/serve-center/vio.js"></script>
@stop



