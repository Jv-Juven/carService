@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－企业用户列表
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/user-list.css">
@stop

@section('business-center-content')
    <div class="business-center-content">
        <ul class="nav nav-pills" id="admin-business-center-user-list-header">
            <li class="nav active">
                <a href="javascript:void(0)" id="all">全部</a>
            </li>
            <li class="nav">
                <a href="javascript:void(0)" id="actived">激活</a>
            </li>
            <li class="nav">
                <a href="javascript:void(0)" id="unactived">等待用户激活</a>
            </li>
            <li class="nav">
                <a href="javascript:void(0)" id="unchecked">未审核</a>
            </li>
            <li class="nav">
                <a href="javascript:void(0)" id="locked">锁定</a>
            </li>
            <li class="nav">
                <a href="javascript:void(0)" id="others">其他</a>
            </li>
            <div class="clear"></div>
        </ul>
    
        <table id="user-list" class="table table-striped table-bordered table-hover">
        	<tr>
        		<th>企业名称</th>
        		<th>营业执照</th>
        		<th>对公帐号</th>
                <th>注册时间</th>
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
                <td>2015/9/21 11:12:21</td>
        		<td class="status">激活</td>
        		<td class="operation">
                    <a href="#">修改费用</a> 
                    <a href="#">修改帐号状态</a> 
                    <a href="#">重置备注码</a>
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
                <td>2015/9/21 11:12:21</td>
                <td class="status">未审核</td>
                <td class="operation">
                    <a href="#">审核</a> 
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
                <td>2015/9/21 11:12:21</td>
                <td class="status">其他</td>
                <td class="operation">
                    <a href="#">等待用户完成注册流程</a> 
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
    