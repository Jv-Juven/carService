@extends('pages.admin.account.layout')

@section('title')
    客服中心－账户设置
@stop

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/account/change-password.css">
@stop

@section('admin-account-content')
    <div class="business-center-content" id="admin-change-password-content">
	    <h4>修改管理员密码</h4>
        <hr />
	    <form class="form-inline">
	    	<input type="hidden" id="admin-id" value="{{{ $admin->admin_id }}}">
	    	<input type="hidden" id="username" value="{{{ $admin->username }}}">
		    <div class="form-group">
			    <label for="old-password">原密码：</label>
			    <input type="password" id="old-password" class="form-control"/>
			</div>
			<div class="form-group">
			    <label for="new-password">新密码：</label>
			    <input type="password" id="new-password" class="form-control"/>
			</div>
			<div class="form-group">
			    <label for="new-password-confirm">确认新密码：</label>
			    <input type="password" id="new-password-confirm" class="form-control"/>
			</div>
		</form>

        <button id="submit-btn" type="button" class="btn btn-primary">提交</button>
	</div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/change-password.js"></script>
@stop
    