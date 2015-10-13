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
            @foreach ($newUsers as $newUser)
            <tr>
                <td class="username">{{{ $newUser->business_info->business_name }}}</td>
                <td class="license-code">{{{ $newUser->business_info->business_licence_no }}}</td>
                <td class="bank-account">
                    对公账户：{{{ $newUser->business_info->bank_account }}} <br/>
                    开户银行：{{{ $newUser->business_info->deposit_bank }}} <br/>
                    开户网点：{{{ $newUser->business_info->bank_outlets }}}
                </td>
                <td class="status">未审核</td>
                <td class="operation">
                    <a href="/admin/business-center/user-info?user_id={{{ $newUser->user_id }}}">
                        <button type="button" class="btn btn-primary">审核</button>
                    </a>
                </td>
            </tr>
            @endforeach
		</table>
		<nav>
            @if ($count < $totalCount)
                {{ $newUsers->links() }}
            @endif
		</nav>
    </div>
@stop

@section('js')
    @parent
@stop
    