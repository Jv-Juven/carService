@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－企业用户查询
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/search-user.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="search-user">
        <h4>企业用户查询</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label for="company-name">企业名称：</label>
                <input type="text" id="company-name" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="company-name">营业执照：</label>
                <input type="text" id="company-name" class="form-control"/>
            </div>
        </form>

        <span class="comment">
            备注：企业名称 / 15位营业执照注册号或18位的统一社会信用代码，任选其一
        </span>

        <button id="search-btn" type="button" class="btn btn-primary">查询</button>
    </div>
@stop

@section('js')
    @parent
@stop
    