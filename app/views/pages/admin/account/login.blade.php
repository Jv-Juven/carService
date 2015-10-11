@extends('pages.admin.layout.master')

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/account/login.css">
@append

@section('title')
    后台管理－登录
@stop

@section('body')
    <div id="main">
    	<div id="login-panel" class="panel panel-primary">
    		<div class="panel-heading">
    			管理员登录
    		</div>
		  	<div class="panel-body">
		  		<form class="form-inline">
		            <div class="form-group">
		                <label for="username">用户名：</label>
               			<input type="text" id="username" class="form-control" />
		            </div>
		            <div class="form-group">
		                <label for="password">密码：</label>
                		<input type="password" id="password" class="form-control" />
		            </div>
		            <div class="form-group">
        				<button id="submit-btn" type="button" class="btn btn-primary">登录</button>
		            </div>
		        </form>
		  	</div>
		  	<div class="panel-footer">

		  	</div>
    	</div>
    </div>
@append

@section('js')
	@parent
    <script type="text/javascript" src="/dist/js/pages/admin/login.js"></script>
@append
