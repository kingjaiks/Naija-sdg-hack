<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://rgw.k8s.apis.ng/centric-platforms/uat/enaira-user/CreateConsumerV2",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '
    "channelCode": "APISNG",
    "uid": "22142360969",
    "uidType": "BVN",
    "reference": "NXG3547585HGTKJHGO",
    "title": "Mr",
    "firstName": "Ifeanyichukwu",
    "middleName": "Gerald",
    "lastName": "Mbah",
    "userName": "icmbah@cbn.gov.ng",
    "phone": "08036349590",
    "emailId": "icmbah@cbn.gov.ng",
    "postalCode": "900110",
    "city": "gwarinpa",
    "address": "Lagos Estate, Abuja",
    "countryOfResidence": "NG",
    "tier": "2",
    "accountNumber": "0025592222",
    "dateOfBirth": "31/12/1987",
    "countryOfBirth": "NG",
    "password": "1234567890",
    "remarks": "Passed",
    "referralCode": "@imbah.01"
  ',
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