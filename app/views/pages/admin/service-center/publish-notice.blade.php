@extends('pages.admin.service-center.layout')

@section('title')
   	客服中心－系统公告
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/service-center/publish-notice.css">
@stop

@section('service-center-content')
    <div class="service-center-content" id="publish-notice-content">
        <h4>发布系统公告</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group" id="title-wrapper">
                <label for="title">标题：</label>
                <input type="text" id="title" class="form-control" placeholder="请输入公告标题" />
            </div>
            <div class="form-group" id="content-wrapper">
                <label for="content">内容：</label>
                <textarea id="content" class="form-control" placeholder="请输入公告内容" rows="15" cols="80"></textarea>
            </div>
            <div class="form-group">
                <button id="submit-btn" type="button" class="btn btn-primary">发布公告</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/publish-notice.js"></script>
@stop
    