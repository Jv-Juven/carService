@extends('pages.admin.layout.master')

@section('css')
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/layout.css">
@append

@section('body')
    <div id="main">
    	<div id="left-nav">
	       	@include('components.admin.left-nav.business-center-left-nav')
    	</div>

    	<div id="right-content">
	       	@yield('business-center-content')
    	</div>

        <div class="clear"></div>
    </div>
@append

@section('js')
	
@append
