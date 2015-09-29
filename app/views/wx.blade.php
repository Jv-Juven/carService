<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>微信扫码支付</title>
</head>
<body>
<?php

$data = array();
$appSecret = Config::get('beeCloud.app_secret');
$data["app_id"] = Config::get('beeCloud.app_id');
$data["timestamp"] = time() * 1000;
$data["app_sign"] = md5($data["app_id"] . $data["timestamp"] . $appSecret);
$data["channel"] = "WX_NATIVE";
$data["total_fee"] = 1;
$data["bill_no"] = "bcdemo" . $data["timestamp"];
//$data["bill_no"] = "bcdemo" . "static";
$data["title"] = "白开水";
$data["return_url"] = "www.baidu.com";
//选填 optional
$data["optional"] = json_decode(json_encode(array("tag"=>"msgtoreturn")));
//选填 return_url
//$data["return_url"] = "http://payservice.beecloud.cn";

try {
    $result = BCRESTApi::bill($data);
    if ($result->result_code != 0) {
        echo json_encode($result);
        exit();
    }
    $code_url = $result->code_url;
    // dd($result);
    ?>
    <div align="center" id="qrcode" >
    </div>
    <div align="center">
        <p>订单号：<?php echo $data["bill_no"]; ?></p>
    </div>
    <br>
    </body>
    <script src="dependency/qrcode.js"></script>
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
    <?php
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
</body>
</html>