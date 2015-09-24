
@extends('layouts.pay.success')

@section('left-nav')
    @include('components.left-nav.message-center-left-nav')
@stop

@section('flow')
    @include('components.vio-process', [ 'num' => 4 ] )
@stop
