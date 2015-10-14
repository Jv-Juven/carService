
@extends('layouts.pay.fail')

@section('left-nav')
    @include('components.left-nav.serve-left-nav')
@stop

@section('flow')
    @include('components.vio-process', [ 'num' => 3 ] )
@stop
