@extends('layouts.submaster')

@section('title')
    信息反馈
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/message-center/feedback/index.css">
@stop

@section('js')
@stop

@section('left-nav')
    @include('components.left-nav.message-center-left-nav')
@stop

@section('right-content')
<div class="fb-wrap">
    <form method="POST" action="" class="fb-form" tartet="fb-form-result">
        <div class="fb-item fb-types clearfix">
            <div class="fb-label">反馈类型:</div>
            <div class="rt-wrap">
                <div class="types-wrap clearfix">
                    <input type="button" value="资讯" class="fb-type fb-type-act">
                    <input type="button" value="建议" class="fb-type">
                    <input type="button" value="投诉" class="fb-type">    
                </div>
            </div>
        </div>
        <div class="fb-item fb-title clearfix">
            <div class="fb-label">标题:</div>
            <div class="rt-wrap">
                <input type="text" class="fb-input">
            </div>
        </div>
        <div class="fb-item fb-content clearfix">
            <div class="fb-label">内容:</div>
            <div class="rt-wrap">
                <textarea name="" id="" class="fb-input"></textarea>
            </div>
        </div>
        <div class="fb-btns">
            <div class="btns-wrap">
                <input type="button" value="重置" class="fb-reset">
                <input type="submit" vlaue="提交" class="fb-submit">
            </div>
        </div>
    </form>
    <iframe id="fb-form-result"></iframe>
</div>
@stop