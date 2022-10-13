<?php

$curl = curl_init();

if(isset($_POST['walletLogin'])){
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt_array($curl, [
	  CURLOPT_URL => "https://rgw.k8s.apis.ng/centric-platforms/uat/CAMLLogin",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "
		'user_id': '$user',
		'password': '$pass',
		'allow_tokenization': 'Y',
		'user_type': 'USER',
		'channel_code': 'APISNG'
	  ",
	  CURLOPT_HTTPHEADER => [
	    "ClientId: 7fbf9ed60bef7be283b17b7eb6b86756",
	    "accept: application/json",
	    "content-type: application/json"
	  ],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}
}
