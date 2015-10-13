@extends('layouts.submaster')

@section('title')
    充值 --- 微信支付
@stop

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/dist/css/common/pay/wechat.css">
@stop

@section('js')
@parent
<script src="/lib/js/qrcode.js"></script>
<script>

    if(<?php echo $code_url != NULL; ?>) {
        var options = {text: "<?php echo $code_url;?>"};
        //参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
        var canvas = BCUtil.createQrCode(options);
        var wording=document.createElement('p');
        wording.innerHTML = "扫我，扫我";
        var element=document.getElementById("qrcode");
        element.appendChild(wording);
        element.appendChild(canvas);
    }
</script>
@stop

@section('right-content')
<div class="pay-wrap">
    <div class="pay-body">
        <div class="pay-qrcode notice">
            <!--<img src="/images/common/qrcode.png">-->
            <div align="center" id="qrcode" >
            </div>
            <div align="center">
                <p>订单号：<?php echo $bill_no; ?></p>
            </div>
            </body>
            <p>请使用微信扫一扫完成支付</p>
        </div>
    </div>
</div>
@stop