@extends('layouts.master')

@section('title')
    全部消息
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/message-center/message/home.css">
@stop

@section('js')
@stop

@section('body')
    @include('pages.message-center.message.base')
@stop