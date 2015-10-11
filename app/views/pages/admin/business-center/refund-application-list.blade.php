@extends('pages.admin.business-center.layout')

@section('title')
    操作中心－违章代办
@stop

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="/dist/css/pages/admin/business-center/refund-application-list.css">
@stop

@section('business-center-content')
    <div class="business-center-content" id="refund-application-list-content">
        <table id="user-list" class="table table-bordered table-hover">
            <tr>
                <th>申请人</th>
                <th>申请退款时间</th>
                <th>审批时间</th>
                <th>退款金额</th>
                <th>审批意见</th>
            </tr>
            @foreach($refundIndents as $refundIndent)
            <tr class="info">
                <td colspan="2" style="border-right:none;">退款单号：{{{ $refundIndent->order->order_id }}}</td>
                @if($refundIndent->order->pay_platform == "0")
                <td colspan="2" style="border-left:none;border-right:none;">支付方式：微信支付</td>
                @else
                <td colspan="2" style="border-left:none;border-right:none;">支付方式：支付宝</td>
                @endif
                <td style="border-left:none;">已付总额：¥{{ $refundIndent->order->capital_sum + $refundIndent->order->service_charge_sum }} 元</td>
            </tr>
            <tr>
                <td>{{{ $refundIndent->user_info->business_name }}}</td>
                <td>{{{ $refundIndent->created_at }}}</td>
                <td>{{{ $refundIndent->approval_at }}}</td>
                <td>{{ $refundIndent->order->capital_sum + $refundIndent->order->service_charge_sum }} 元</td>
                @if($refundIndent->comment == "0")
                <td>审核中</td>
                @elseif($refundIndent->comment == "1")
                <td>审核通过退款中</td>
                @elseif($refundIndent->comment == "2")
                <td>退款成功</td>
                @elseif($refundIndent->comment == "3")
                <td>审核不通过</td>
                @else
                <td>退款失败</td>
                @endif
            </tr>
            <tr>
                <td colspan="5">
                    <a href="/admin/business-center/refund-status?indent_id={{{ $refundIndent->order_id }}}" target="_blank">
                        <button type="button" class="btn btn-primary" style="float: right;margin-right: 20px;">查看退款状态</button>
                    </a>
                    <a href="/admin/business-center/refund-indent-info?indent_id={{{ $refundIndent->order_id }}}" target="_blank">
                        <button type="button" class="btn btn-primary" style="float: right;margin-right: 20px;">查看订单详情</button>
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
        <nav>
            @if ($count < $totalCount)
                {{ $refundIndents->links() }}
            @endif
        </nav>
    </div>
@stop

@section('js')
    @parent
@stop
    