@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－企业用户信息
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/user-info.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="user-info-content">
        <h4>注册信息</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label for="company-name">登陆邮箱：</label>
                <span>{{{ $user->login_account }}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">帐号状态：</label>
                @if($user->status === "10")
                <span>未激活邮箱</span>
                @elseif($user->status === "11")
                <span>未登记信息</span>
                @elseif($user->status === "20")
                <span>信息审核中</span>
                @elseif($user->status === "21")
                <span>等待用户校验激活</span>
                @elseif($user->status === "22")
                <span>激活</span>
                @elseif($user->status === "30")
                <span>账号锁定</span>
                @endif
                <a style="float:right;margin-right:100px;" href="/admin/business-center/change-user-status?user_id={{{ $user->user_id }}}">修改状态</a>
            </div>
            <div class="form-group">
                <label for="company-name">打款备注码：</label>
                <span>该企业用户信息未审核，未设置打款备注码</span>
                <a style="float:right;margin-right:100px;" href="/admin/business-center/check-new-user?user_id={{{ $user->user_id }}}">设置</a>
            </div>
            <div class="form-group">
                <label for="company-name">费用设置：</label>
                <span>默认为统一费用</span>
                <a style="float:right;margin-right:100px;" href="/admin/business-center/change-default-service-univalence">查看/修改默认费用</a>
                <a style="float:right;margin-right:20px;" href="/admin/business-center/change-service-univalence?user_id={{{ $user->user_id }}}">查看/修改费用</a>
            </div>
            <div class="form-group">
                <label for="company-name">注册时间：</label>
                <span>{{{ $user->created_at }}}</span>
            </div>
        </form>
        <h4>主体信息登记</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label for="company-name">企业名称：</label>
                <span>{{{ $user->business_info->business_name }}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">营业执照注册号：</label>
                <span>{{{ $user->business_info->business_licence_no }}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">营业执照照片：</label>
                <span>
                    <img src="{{{ $user->business_info->business_licence_scan_path }}}" width="400" height="300" />
                </span>
            </div>
        </form>
        <h4>对公账户信息</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label for="company-name">对公帐号：</label>
                <span>{{{ $user->business_info->bank_account }}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">开户银行：</label>
                <span>{{{ $user->business_info->deposit_bank }}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">开户网点：</label>
                <span>{{{ $user->business_info->bank_outlets }}}</span>
            </div>
        </form>
        <h4>运营者信息登记</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label for="company-name">运营者身份证姓名：</label>
                <span>{{{ $user->business_info->operational_name }}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">运营者身份证号码：</label>
                <span>{{{ $user->business_info->operational_card_no }}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">运营者手机号码：</label>
                <span>{{{ $user->business_info->operational_phone }}}</span>
            </div>
            <div class="form-group">
                <label for="company-name">运营者身份证正面扫描件：</label>
                <span>
                    <img src="{{{ $user->business_info->id_card_front_scan_path }}}" width="300" height="189" />
                </span>
            </div>
            <div class="form-group">
                <label for="company-name">运营者身份证反面扫描件：</label>
                <span>
                    <img src="{{{ $user->business_info->id_card_back_scan_path }}}" width="300" height="189" />
                </span>
            </div>
        </form>
    </div>
@stop

@section('js')
    @parent
@stop
    