@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－用户查询统计
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/user-query-count.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="user-query-count-content">
        <h4>用户查询统计</h4>
        <hr />
        <form class="form-inline">
	        <div class="form-group" id="appkey-wrapper">
	            <label for="appkey">appkey：</label>
	            <input type="text" id="appkey" class="form-control" value="{{{ $appkey }}}"/>
	        </div>
        </form>

        <button id="search-btn" type="button" class="btn btn-primary">查询</button>

        <hr />
        <div id="search-result"></div>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/user-query-count.js"></script>
@stop
    