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
                <a href="/admin/business-center/user-list" id="all">全部</a>
            </li>
            <li class="nav">
                <a href="/admin/business-center/user-list?type=actived" id="actived">激活</a>
            </li>
            <li class="nav">
                <a href="/admin/business-center/user-list?type=unactived" id="unactived">等待用户激活</a>
            </li>
            <li class="nav">
                <a href="/admin/business-center/user-list?type=unchecked" id="unchecked">未审核</a>
            </li>
            <li class="nav">
                <a href="/admin/business-center/user-list?type=locked" id="locked">锁定</a>
            </li>
            <li class="nav">
                <a href="/admin/business-center/user-list?type=others" id="others">其他</a>
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
            @foreach($users as $user)
        	<tr>
        		<td class="username">{{{ $user->business_info->business_name }}}</td>
        		<td class="license-code">{{{ $user->business_info->business_licence_no }}}</td>
        		<td class="bank-account">
                    {{{ $user->business_info->bank_account }}} <br/>
                    {{{ $user->business_info->deposit_bank }}} <br/>
                    {{{ $user->business_info->bank_outlets }}}
                </td>

                <td>2015/9/21 11:12:21</td>
                @if($user->status === "20")
                <td class="status">未审核</td>
                @elseif($user->status === "21")
                <td class="status">等待用户激活</td>
                @elseif($user->status === "22")
                <td class="status">激活</td>
                @elseif($user->status === "30")
                <td class="status">锁定</td>
                @else
                <td class="status">其他</td>
                @endif
        		
        		<td class="operation">
                    @if($user->status === "20")
                    <a href="/admin/business-center/check-new-user?user_id={{{$user->user_id}}}">设置备注码</a>
                    @elseif($user->status === "21")
                    <a href="/admin/business-center/check-new-user?user_id={{{$user->user_id}}}">重置备注码</a>
                    @elseif($user->status === "22")
                    <a href="/admin/business-center/change-service-univalence?user_id={{{$user->user_id}}}">修改费用</a> 
                    <a href="/admin/business-center/change-user-status?user_id={{{$user->user_id}}}">修改帐号状态</a> 
                    @elseif($user->status === "30")
                    <a href="/admin/business-center/change-user-status?user_id={{{$user->user_id}}}">修改帐号状态</a> 
                    @endif
        		</td>
        	</tr>
            @endforeach
		</table>
		<nav>
            @if ($count < $totalCount)
                {{ $users->links() }}
            @endif
        </nav>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/user-list.js"></script>
@stop
    