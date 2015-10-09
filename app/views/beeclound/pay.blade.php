<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>微信扫码支付</title>
</head>
<body>
	<div align="center" id="qrcode" >
	    </div>
	    <div align="center">
	        <p>订单号：<?php echo $bill_no; ?></p>
	    </div>
	    <br>
	</body>
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
</html>