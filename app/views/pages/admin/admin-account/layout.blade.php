@extends('pages.admin.layout.master')

@section('css')
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/layout.css">
@append

@section('body')
    <div id="main">
    	<div id="left-nav">
	       	@include('components.admin.left-nav.admin-account-left-nav')
    	</div>

    	<div id="right-content">
	       	@yield('account-center-content')
    	</div>

        <div class="clear"></div>
    </div>
@append

@section('js')
	
@append
