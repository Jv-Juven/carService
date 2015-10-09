@extends('layouts.submaster')

@section('title')
    全部消息
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/message-center/message/base.css">
@stop

@section('js')
	@parent
@stop

@section('left-nav')
    @include('components.left-nav.message-center-left-nav')
@stop

@section('right-content')
    @include('pages.message-center.message.base', [
        'notices'           => $paginator->getCollection(),
        'paginator'         => $paginator
    ])
@stop