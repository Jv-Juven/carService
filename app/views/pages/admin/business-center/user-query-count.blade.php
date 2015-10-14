@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－用户查询统计
@stop

@section('css')
	@parent
    <link rel="stylesheet" type="text/css" href="/lib/css/bootstrap/datetimepicker.css" />
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/user-query-count.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="user-query-count-content">
        <h4>用户查询统计</h4>
        <hr />
        <form class="form-inline">
	        <div class="form-group" id="uid-wrapper">
	            <label for="uid">用户ID：</label>
	            <input type="text" id="uid" class="form-control" value="{{{ $uid }}}"/>
	        </div>
            <div class="form-group">
                <label for="company-name">开始时间：</label>
                <div class="input-group date form-date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly id="start-date-picker">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
            <div class="form-group">
                <label for="company-name">截止时间：</label>
                <div class="input-group date form-date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly id="end-date-picker">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </form>

        <button id="search-btn" type="button" class="btn btn-primary">查询</button>

        <hr />
        <div id="search-result"></div>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/lib/js/lodash.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/lib/js/moment.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/lib/js/bootstrap/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/lib/js/bootstrap/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/dist/js/pages/admin/user-query-count.js"></script>
@stop
    