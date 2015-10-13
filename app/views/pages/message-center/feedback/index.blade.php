@extends('layouts.submaster')

@section('title')
    信息反馈
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/pages/message-center/feedback/index.css">
@stop

@section('js')
@parent
<script type="text/javascript" src="/dist/js/pages/message-center/feedback/index.js"></script>
@stop

@section('left-nav')
    @include('components.left-nav.message-center-left-nav')
@stop

@section('right-content')
<div class="fb-wrap">
    <form method="POST" action="" id="fb-form" class="fb-form" target="fb-form-result">
        <div class="fb-item fb-types clearfix">
            <div class="fb-label">反馈类型:</div>
            <div class="rt-wrap">
                <div class="types-wrap clearfix">
                    <label class="type-checkbox">
                        <input name="type" type="radio" class="cbox-clk">
                        <span>资讯</span>
                    </label>
                    <label class="type-checkbox">
                        <input name="type" type="radio" class="cbox-clk">
                        <span>建议</span>
                    </label>
                    <label class="type-checkbox">
                        <input name="type" type="radio" class="cbox-clk">
                        <span>投诉</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="fb-item fb-title clearfix">
            <div class="fb-label">标题:</div>
            <div class="rt-wrap">
                <input name="title" type="text" required="required" class="fb-input">
            </div>
        </div>
        <div class="fb-item fb-content clearfix">
            <div class="fb-label">内容:</div>
            <div class="rt-wrap">
                <textarea name="content" required="required" class="fb-input"></textarea>
            </div>
        </div>
        <div class="fb-btns">
            <div class="btns-wrap">
                <input type="reset" value="重置" class="fb-reset">
                <input type="submit" vlaue="提交" class="fb-submit">
            </div>
        </div>
    </form>
    <iframe name="fb-form-result" id="fb-form-result"></iframe>
</div>
@stop

