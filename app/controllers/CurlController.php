<?php

class CurlController extends BaseController{

	//get请求
	public static function get($url)
	{
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url) ;
        # curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!curl_exec($ch))
        {
            error_log(curl_error($ch));
            $data = '';
        }
        else
        {
            $data = curl_multi_getcontent($ch);
        }
        curl_close($ch);

        return $data;
	}

	//post请求
	public static function post($url, $parm)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);//抓取网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果以流输出
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parm);

		if (!curl_exec($ch))
        {
            error_log(curl_error($ch));
            $data = '';
        }
        else
        {
            $data = curl_multi_getcontent($ch);
        }
        curl_close($ch);

        return $data;
	}


























}