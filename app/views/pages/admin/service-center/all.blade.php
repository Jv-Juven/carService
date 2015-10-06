@extends('pages.admin.service-center.layout')

@section('title')
   	客服中心－全部
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/service-center/all.css">
@stop

@section('left-nav')
    
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
        	<tr>
        		<td class="username">广州紫睿科技有限公司</td>
        		<td class="title">订单提交了这么久怎么还没处理啊</td>
        		<td class="content">订单提交了这么久怎么还没处理啊订单提交了这么久怎么还没处理啊订单提交了这么久怎么还没处理啊订单提交了这么久怎么还没处理啊</td>
        		<td class="time">2015/9/21 11:12:21</td>
        		<td class="status">已处理</td>
        		<td class="operation">
        			<button type="button" class="btn btn-success disabled">已处理</button>
        		</td>
        	</tr>
        	<tr>
        		<td class="username">广州紫睿科技有限公司</td>
        		<td class="title">订单提交了这么久怎么还没处理啊</td>
        		<td class="content">订单提交了这么久怎么还没处理啊订单提交了这么久怎么还没处理啊订单提交了这么久怎么还没处理啊订单提交了这么久怎么还没处理啊</td>
        		<td class="time">2015/9/21 11:12:21</td>
        		<td class="status">未处理</td>
        		<td class="operation">
        			<button type="button" class="btn btn-primary">处理</button>
        		</td>
        	</tr>
		</table>
		<nav>
		 	<ul class="pager">
		    	<li><a href="#">上一页</a></li>
		    	<li><a href="#">下一页</a></li>
		  	</ul>
		</nav>
    </div>
@stop

@section('js')
    @parent
@stop
    