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
        <input type="hidden" id="user-id" value="{{{ $userId }}}" />
        <h4>修改用户状态</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label for="company-name">企业名称：</label>
                <span>{{{ $name }}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">状态：</label>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        @if($status == "20")
                        <span id="status-name">未审核</span>
                        @elseif($status == "21")
                        <span id="status-name">等待用户激活</span>
                        @elseif($status == "22")
                        <span id="status-name">激活</span>
                        @elseif($status == "30")
                        <span id="status-name">锁定</span>
                        @endif 
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a class="dropdown-item" data-name="active-select" href="javascript:void(0);">激活</a></li>
                        <li><a class="dropdown-item" data-name="unactive-select" href="javascript:void(0);">等待用户激活</a></li>
                        <li><a class="dropdown-item" data-name="unchecked-select" href="javascript:void(0);">未审核</a></li>
                        <li><a class="dropdown-item" data-name="lock-select" href="javascript:void(0);">锁定</a></li>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <label for="company-name">状态说明：</label>
                @if($status == "20")
                <span id="status-intro">用户信息待审核，该用户无法进行任何操作</span>
                @elseif($status == "21")
                <span id="status-intro">等待用户回填校验码之后激活账号，在此之前该用户无法进行任何操作</span>
                @elseif($status == "22")
                <span id="status-intro">企业用户的账号状态正常，可正常使用车务服务系统的所有服务</span>
                @elseif($status == "30")
                <span id="status-intro">账号被锁定，该用户将无法进行任何操作</span>
                @endif 
            </div>
        </form>

        <button id="submit-btn" type="button" class="btn btn-primary">提交</button>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/change-user-status.js"></script>
@stop
    