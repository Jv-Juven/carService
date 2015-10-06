@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－新注册企业用户
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/new-user-list.css">
@stop

@section('business-center-content')
    <div class="business-center-content">
        <h4>新注册企业用户</h4>
        <hr />
        <table id="new-user-list" class="table table-striped table-bordered table-hover">
        	<tr>
        		<th>企业名称</th>
        		<th>营业执照</th>
        		<th>对公帐号</th>
        		<th>帐号状态</th>
        		<th>操作</th>
        	</tr>
        	<tr>
        		<td class="username">广州紫睿科技有限公司</td>
        		<td class="license-code">123456789011121</td>
        		<td class="bank-account">
                    6222026542378654219 <br/>
                    开户银行：工商银行 <br/>
                    开户网点：广东
                </td>
        		<td class="status">未审核</td>
        		<td class="operation">
        			<button type="button" class="btn btn-primary">审核</button>
        		</td>
        	</tr>
        	<tr>
                <td class="username">广州紫睿科技有限公司</td>
                <td class="license-code">123456789011121</td>
                <td class="bank-account">
                    6222026542378654219 <br/>
                    开户银行：工商银行 <br/>
                    开户网点：广东
                </td>
                <td class="status">未审核</td>
                <td class="operation">
                    <button type="button" class="btn btn-primary">审核</button>
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
    