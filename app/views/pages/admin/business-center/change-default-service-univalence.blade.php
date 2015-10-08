@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－修改默认服务费用
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/change-service-univalence.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="change-service-univalence-content">
        <ul id="change-default-query-univalence-header" class="nav nav-tabs">
            <li role="presentation" class="active"><a href="/admin/business-center/change-default-service-univalence">服务费用</a></li>
            <li role="presentation"><a href="/admin/business-center/change-default-query-univalence">查询费用</a></li>
        </ul>
        <form class="form-inline">
            <div class="form-group">
                <label for="company-name">企业名称：</label>
                <div class="intro">广州车尚信息有限公司</div>
            </div>
            <div class="form-group">
                <label for="company-name">说明：</label>
                <div class="intro">输入“特价”后，对该企业收取的服务费用，将按照“特价”金额计算；不填则按“默认费用”金额计算</div>
            </div>
        </form>
        <table id="service-univalence" class="table table-striped table-bordered table-hover">
            <tr>
                <th>费用分类</th>
                <th>费用名称</th>
                <th>默认费用</th>
                <th>特价</th>
            </tr>
            <tr>
                <td>企业服务费</td>
                <td>企业用户票证快递费</td>
                <td>15</td>
                <td>
                    <input type="text" class="form-control" id="express-univalence" />
                </td>
            </tr>
            <tr>
                <td>企业服务费</td>
                <td>企业用户代办服务费</td>
                <td>10</td>
                <td>
                    <input type="text" class="form-control" id="agency-univalence" />
                </td>
            </tr>
        </table>

        <button id="submit-btn" type="button" class="btn btn-primary">提交</button>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/change-default-service-univalence.js"></script>
@stop
    