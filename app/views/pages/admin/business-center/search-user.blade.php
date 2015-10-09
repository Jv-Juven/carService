@extends('pages.admin.business-center.layout')

@section('title')
   	操作中心－企业用户查询
@stop

@section('css')
	@parent
	<link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/search-user.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="search-user">
        <h4>企业用户查询</h4>
        <hr />
        <form class="form-inline">
            <div class="form-group">
                <label for="company-name">查询字段：</label>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span id="dropdown-show">企业名称</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a id="company-name-select" href="javascript:void(0);">企业名称</a></li>
                        <li><a id="license-code-select" href="javascript:void(0);">营业执照</a></li>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <label for="company-name">企业名称：</label>
                <input type="text" id="company-name" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="company-name">营业执照：</label>
                <input type="text" id="license-code" class="form-control"/>
            </div>
        </form>

        <span class="comment">
            备注：企业名称 / 15位营业执照注册号或18位的统一社会信用代码，任选其一
        </span>

        <button id="search-btn" type="button" class="btn btn-primary">查询</button>
    
        <hr />
        <div id="search-result">
            
        </div>
        <script type="text/template" id="search-result-template">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>企业名称</th>
                    <th>营业执照</th>
                    <th>注册时间</th>
                    <th>帐号状态</th>
                    <th></th>
                </tr>
                <% for(var i = 0, length = users.length; i < length; i ++) { %>
                <tr>
                    <td><%= users[i].business_name %></td>
                    <td><%= users[i].business_licence_no %></td>
                    <td><%= users[i].user.created_at %></td>
                    <% if(users[i].user.status == 10) { %>
                    <td>未激活邮箱</td>
                    <% } else if(users[i].user.status == 11) { %>
                    <td>未登记信息</td>
                    <% } else if(users[i].user.status == 20) { %>
                    <td>信息审核中</td>
                    <% } else if(users[i].user.status == 21) { %>
                    <td>等待用户校验激活</td>
                    <% } else if(users[i].user.status == 22) { %>
                    <td>激活</td>
                    <% } else if(users[i].user.status == 30) { %>
                    <td>账号锁定</td>
                    <% } %>
                    <td><a target="_blank" href="/admin/business-center/user-info?user_id=<%= users[i].user.user_id %>">详细信息</a></td>
                </tr>
                <% } %>
            </table>
        </script>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/lib/js/lodash.min.js"></script>
    <script type="text/javascript" src="/dist/js/pages/admin/search-user.js"></script>
@stop
    