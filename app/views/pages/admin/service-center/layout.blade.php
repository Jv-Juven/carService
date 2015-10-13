@extends('pages.admin.layout.master')

@section('css')
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/service-center/layout.css">
@append

@section('body')
    <div id="main">
    	<div id="left-nav">
	       	@include('components.admin.left-nav.service-center-left-nav')
    	</div>

    	<div id="right-content">
	       	@include('components.admin.service-center-header')
	       	@yield('service-center-content')
    	</div>

        <div class="clear"></div>
    </div>
@append

@section('js')
	
@append
