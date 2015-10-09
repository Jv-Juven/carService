@extends('pages.admin.service-center.layout')

@section('title')
   	客服中心－全部
@stop

@section('css')
	@parent
	<!-- <link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/service-center/feedback.css"> -->
@stop

@section('service-center-content')
	<hr />
    <div class="service-center-content">
        <table class="table table-striped table-bordered table-hover">
        	<tr>
        		<th>用户名称</th>
        		<th>标题</th>
        		<th>内容</th>
        		<th>提交时间</th>
        		<th>处理状态</th>
        		<th>操作</th>
        	</tr>
            @foreach($feedbacks as $feedback)
        	<tr>
                <td style="display:none;"><input type="hidden" class="feedback-id" value="{{{ $feedback->feedback_id }}}"></td>
        		<td class="username">广州紫睿科技有限公司</td>
        		<td class="title">{{{ $feedback->title }}}</td>
        		<td class="content">{{{ $feedback->content }}}</td>
        		<td class="time">{{{ $feedback->created_at }}}</td>
                @if($feedback->status == 0)
                <td class="status">未处理</td>
                @else
        		<td class="status">已处理</td>
                @endif
        		<td class="operation">
                    @if($feedback->status == 0)
                    <button type="button" class="btn btn-primary treat-btn">处理</button>
                    @else
                    <button type="button" class="btn btn-success disabled">已处理</button>
                    @endif
        		</td>
        	</tr>
            @endforeach
		</table>
		<nav>
            @if ($count < $totalCount)
                {{ $feedbacks->links() }}
            @endif
        </nav>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/feedback.js"></script>
@stop
    