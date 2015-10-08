@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－审核企业用户
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/change-user-status.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="change-user-status-content">
        <h4>企业用户审核</h4>
        <hr />
        <form class="form-inline">
            <input type="hidden" id="user-id" value="{{{ $user->user_id }}}">
            <div class="form-group">
                <label for="company-name">企业名称：</label>
                <span>{{{ $user->business_info->business_name }}}</span>
            </div>
            <div class="form-group">
                <label for="transfer-code">打款备注码：</label>
                <input type="text" id="remark-code" class="form-control" placeholder="请输入六位打款验证码"/>
            </div>
            <div class="form-group">
                <label for="company-name">说明：</label>
                <span>往企业用户的对公账号转0.01元，并附上6位数字的备注码，企业用户初次登录时将要求其输入以验证其身份。</span>
            </div>
        </form>

        <button id="submit-btn" type="button" class="btn btn-primary">提交</button>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/check-new-user.js"></script>
@stop
    