@extends('pages.admin.business-center.layout')

@section('title')
    操作中心－修改服务费用
@stop

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/change-service-univalence.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="change-service-univalence-content">
        <ul id="change-query-univalence-header" class="nav nav-tabs">
            <li role="presentation"><a href="/admin/business-center/change-default-service-univalence">服务费用</a></li>
            <li role="presentation" class="active"><a href="/admin/business-center/change-default-query-univalence">查询费用</a></li>
        </ul>
        <form class="form-inline">
            <div class="form-group">
                <label for="company-name">说明：</label>
                <div class="intro">所有用户默认收取的费用如下表所示。如需对某企业用户的某项费用设定特价，请在 [用户管理]-[企业用户搜索] 中进行搜索，并进行设置。</div>
            </div>
        </form>
        <table id="service-univalence" class="table table-striped table-bordered table-hover">
            <tr>
                <th>费用分类</th>
                <th>费用名称</th>
                <th>适用用户类型</th>
                <th>默认费用</th>
            </tr>
            <tr>
                <td>查询</td>
                <td>车辆违章查询</td>
                <td>企业用户</td>
                <td>
                    <input type="text" class="form-control" id="violation-univalence" value="{{{ $violationUnivalence }}}" />
                </td>
            </tr>
            <tr>
                <td>查询</td>
                <td>驾驶证查询</td>
                <td>企业用户</td>
                <td>
                    <input type="text" class="form-control" id="license-univalence" value="{{{ $licenseUnivalence }}}" />
                </td>
            </tr>
            <tr>
                <td>查询</td>
                <td>机动车信息查询</td>
                <td>企业用户</td>
                <td>
                    <input type="text" class="form-control" id="car-univalence" value="{{{ $carUnivalence }}}" />
                </td>
            </tr>
        </table>

        <button id="submit-btn" type="button" class="btn btn-primary">提交</button>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/dist/js/pages/admin/change-default-query-univalence.js"></script>
@stop
    