<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://rgw.k8s.apis.ng/centric-platforms/uat/enaira-user/PayWithToken",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => {
    "amount": "100",
    "phone_number": "08056064768",
    "reference": "NXG263849456678494949",
    "transaction_token": "1234",
    "invoice_id": "01G9S2M2P1A2K06J9H1TDZPBTJ",
    "product_code": "003",
    "channel_code": "APISNG"
  },
  CURLOPT_HTTPHEADER => [
    "ClientId: clientId",
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