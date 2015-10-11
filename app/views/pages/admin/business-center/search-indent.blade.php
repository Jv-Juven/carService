@extends('pages.admin.business-center.layout')

@section('title')
    操作中心－订单搜索
@stop

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="/lib/css/bootstrap/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/search-indent.css" />
@stop

@section('business-center-content')
    <div class="business-center-content" id="search-indent-content">
        <input type="hidden" id="type" value="{{{ $type }}}" />
        <ul id="search-indent-header" class="nav nav-tabs">
            @if($type == "id")
            <li role="presentation" class="active"><a href="/admin/business-center/search-indent?type=id">按订单编号查询</a></li>
            <li role="presentation"><a href="/admin/business-center/search-indent?type=info">按订单信息查询</a></li>
            @elseif($type == "info")
            <li role="presentation"><a href="/admin/business-center/search-indent?type=id">按订单编号查询</a></li>
            <li role="presentation" class="active"><a href="/admin/business-center/search-indent?type=info">按订单信息查询</a></li>
            @endif
        </ul>
        <form class="form-inline">
            @if($type == "id")
            <div class="form-group">
                <label for="company-name">订单编号：</label>
                <input type="text" id="indent-id" class="form-control"/>
            </div>
            <div class="form-group">
                <button id="search-by-id-btn" type="button" class="btn btn-primary">查询</button>
            </div>
            @elseif($type == "info")
            <div class="form-group">
                <label for="company-name">车牌号码：</label>
                <div class="dropdown" id="province-dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="province-dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span id="province-dropdown-show">粤</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu province-dropdown-menu" aria-labelledby="province-dropdown-btn">
                        
                    </ul>
                    <script type="text/template" id="province-select-template">
                        <li><a class="province-select" data-name="<%= name %>" href="javascript:void(0);"><%= name %></a></li>
                    </script>
                </div>
                <input type="text" id="license-plate" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="company-name">业务状态：</label>
                <div class="dropdown" id="status-dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="status-dropdown-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span id="status-dropdown-show">全部</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu status-dropdown-menu" aria-labelledby="status-dropdown-btn">
                        <li><a class="status-select" data-name="all" href="javascript:void(0);">全部</a></li>
                        <li><a class="status-select" data-name="0" href="javascript:void(0);">未受理</a></li>
                        <li><a class="status-select" data-name="1" href="javascript:void(0);">已受理</a></li>
                        <li><a class="status-select" data-name="2" href="javascript:void(0);">办理中</a></li>
                        <li><a class="status-select" data-name="3" href="javascript:void(0);">已完成</a></li>
                        <li><a class="status-select" data-name="4" href="javascript:void(0);">已关闭</a></li>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <label for="company-name">下单时间：</label>
                <div class="input-group date form-date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly id="start-date-picker">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                 至 
                <div class="input-group date form-date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly id="end-date-picker">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
            <div class="comment">
                温馨提示：如果没有选择时间范围，默认查询1年以内的记录
            </div>
            <div class="form-group">
                <button id="search-by-info-btn" type="button" class="btn btn-primary">查询</button>
            </div>
            @endif
        </form>
        <hr />
        <div id="search-result"></div>
        <script type="text/template" id="search-result-template">
            <table id="search-indent-list" class="table table-bordered table-hover">
                <tr>
                    <th>违章时间</th>
                    <th>违章地点</th>
                    <th>违章行为</th>
                    <th>细项/元</th>
                    <th>金额/元</th>
                    <th>交易状态</th>
                </tr>
                <% for(var i = 0, length = indents.length; i < length; i ++) { %>
                <tr class="info">
                    <td><%= indents[i].car_plate_no %></td>
                    <td colspan="2">订单编号：<%= indents[i].order_id %></td>
                    <td colspan="2">下单时间：<%= indents[i].created_at %></td>
                    <% if(indents[i].process_status == "0") { %>
                    <td>处理状态：未受理</td>
                    <% } else if(indents[i].process_status == "1") { %>
                    <td>处理状态：已受理</td>
                    <% } else if(indents[i].process_status == "2") { %>
                    <td>处理状态：办理中</td>
                    <% } else if(indents[i].process_status == "3") { %>
                    <td>处理状态：已完成</td>
                    <% } else if(indents[i].process_status == "4") { %>
                    <td>处理状态：已关闭</td>
                    <% } %>
                </tr>
                <% for(var j = 0, length_1 = indents[i].traffic_violation_info.length; j < length_1; j ++) { %>
                <tr>
                    <td><%= indents[i].traffic_violation_info[j].rep_event_time %></td>
                    <td><%= indents[i].traffic_violation_info[j].rep_event_addr %></td>
                    <td><%= indents[i].traffic_violation_info[j].rep_violation_behavior %></td>
                    <td>
                        本金：<%= indents[i].traffic_violation_info[j].rep_priciple_balance %> <br />
                        服务费：<%= indents[i].traffic_violation_info[j].rep_service_charge %>
                    </td>
                    <td><%= indents[i].traffic_violation_info[j].rep_priciple_balance + indents[i].traffic_violation_info[j].rep_service_charge %></td>
                    <% if(j == 0) { %>
                    <% if(indents[i].trade_status == "0") { %>
                    <td rowspan="<%= indents[i].traffic_violation_info.length %>">等待付款</td>
                    <% } else if (indents[i].traffic_violation_info[j].trade_status == "1") { %>
                    <td rowspan="<%= indents[i].traffic_violation_info.length %>">已付款</td>
                    <% } else if (indents[i].traffic_violation_info[j].trade_status == "2") { %>
                    <td rowspan="<%= indents[i].traffic_violation_info.length %>">申请退款</td>
                    <% } else if (indents[i].traffic_violation_info[j].trade_status == "3") { %>
                    <td rowspan="<%= indents[i].traffic_violation_info.length %>">已退款</td>
                    <% } else if (indents[i].traffic_violation_info[j].trade_status == "4") { %>
                    <td rowspan="<%= indents[i].traffic_violation_info.length %>">退款失败</td>
                    <% } %>
                    <% } %>
                </tr>
                <% } %>
                <% } %>
            </table>
        </script>
    </div>
@stop

@section('js')
    @parent
    <script type="text/javascript" src="/lib/js/lodash.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/lib/js/moment.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/lib/js/bootstrap/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/lib/js/bootstrap/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/dist/js/pages/admin/search-indent.js"></script>
@stop
    