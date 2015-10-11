@extends('pages.admin.layout.master')

@section('title')
    页面出错了
@stop

@section('body')
	@if(isset($errMsg))
	<p style="margin-left: 200px;background-color: white;">{{{ $errMsg }}}</p>
	@else
	<p style="margin-left: 200px;background-color: white;">您访问的页面出错了，请联系开发人员处理！</p>
	@endif
@stop

