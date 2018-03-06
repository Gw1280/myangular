<?php
	include_once 'config.php';
	$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APPID.'&redirect_uri=http%3a%2f%2f1.mdk0205.applinzi.com%2fsample.html&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
	

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APPID.'&redirect_uri=http%3a%2f%2f1.mdk0205.applinzi.com%2fsample.html&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect');
	//curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type: application/json');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_M);
	curl_setopt($ch, CURLOPT_HEADER, false); 
	//curl_setopt($ch,CURLOPT_HEADERFUNCTION,);
	curl_setopt($ch,CURLOPT_HEADERDATA,$tourl);
	$res = curl_exec($ch);
	curl_close($ch);
?>