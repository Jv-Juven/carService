@extends('layouts.master')


@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/message-center/message/detail.css">
@stop

@section('js')
@stop

@section('body')
<div class="message-wrap">
    <div class="message-body">
        <div class="message-content">
            <h2 class="message-title">{{{ $notice->title }}}</h2>
            <p class="message-info">
                <span>发布日期:</span>
                <span class="info-date">{{{ $notice->created_at }}}</span>
            </p>
            <div class="content-wrap">
                {{{ $notice->content }}}
            </div>
        </div>
    </div>
</div>
@stop