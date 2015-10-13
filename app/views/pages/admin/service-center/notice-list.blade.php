@extends('pages.admin.service-center.layout')

@section('title')
   	客服中心－系统公告
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/service-center/notice-list.css">
@stop

@section('service-center-content')
    <h4>系统公告列表</h4>
	<hr />
    <div class="service-center-content" id="notice-list-content">
        <table class="table table-striped table-bordered table-hover">
        	<tr>
        		<th>标题</th>
        		<th>内容</th>
        		<th>发布时间</th>
        	</tr>
            @foreach($notices as $notice)
        	<tr>
        		<td class="title">{{{ $notice->title }}}</td>
        		<td class="content">{{{ $notice->content }}}</td>
        		<td class="time">{{{ $notice->created_at }}}</td>
        	</tr>
            @endforeach
		</table>
		<nav>
            @if ($count < $totalCount)
                {{ $notices->links() }}
            @endif
        </nav>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/notice-list.js"></script>
@stop
    