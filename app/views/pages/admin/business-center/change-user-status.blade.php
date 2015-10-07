@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－修改用户状态
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/change-user-status.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="change-user-status-content">
        <h4>修改用户状态</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label for="company-name">企业名称：</label>
                <span>广州车尚车务服务有限公司</span>
            </div>
            <div class="form-group">
                <label for="company-name">状态：</label>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        请选择状态
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">激活</a></li>
                        <li><a href="#">锁定</a></li>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <label for="company-name">状态说明：</label>
                <span>企业用户的账号状态正常，可正常使用车务服务系统的所有服务</span>
            </div>
        </form>

        <button id="submit-btn" type="button" class="btn btn-primary">提交</button>
    </div>
@stop

@section('js')
    @parent
@stop
    