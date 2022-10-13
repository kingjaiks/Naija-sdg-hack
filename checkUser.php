<?php

if(isset($_POST['getUserData'])){
  if($_POST['getUserData'] === 'true'){
    

    $type = $_POST['type'];

    
    function phoneChecks(){
      $curl = curl_init();
      $setId = $_POST['phone'];
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt_array($curl, [
        CURLOPT_URL => "https://rgw.k8s.apis.ng/centric-platforms/uat/enaira-user/GetUserDetailsByPhone",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "
          'phone_number': '$setId',
          'user_type': 'USER',
          'channel_code': 'APISNG'
        ",
        CURLOPT_HTTPHEADER => [
          "ClientId: 7fbf9ed60bef7be283b17b7eb6b8675",
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

    function aliasCheck(){
      $curl = curl_init();
      $setId = $_POST['phone'];
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt_array($curl, [
        CURLOPT_URL => "https://rgw.k8s.apis.ng/centric-platforms/uat/enaira-user/GetUserDetailsByWalletAlias",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "
          'wallet_alias': '$setId',
          'user_type': 'user',
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


    if($type == 'phone'){
      phoneChecks();
    } else if($type == 'alias'){
      aliasCheck();
    }


  }
}

// response structure'
// {
//     "response_code": "00",
//     "response_message": "Successful Request",
//     "response_data": {
//         "uid": "64625226407",
//         "uid_type": "BVN",
//         "kyc_status": "ACCEPTED",
//         "phone": "08056064768",
//         "email_id": "64625226407@enaira.gov.ng",
//         "first_name": "EMMANUEL",
//         "last_name": "ONUOHA",
//         "middle_name": "EZECHI",
//         "title": "",
//         "town": "Abuja",
//         "state_of_residence": "15",
//         "lga": "Ezinihitte",
//         "address": "35,JAMIU RAJI STREET,AGODO EGBE LAGOS",
//         "country_of_origin": "NG",
//         "account_number": "1000258985",
//         "tier": "2",
//         "country_of_birth": "NG",
//         "state_of_origin": "10",
//         "inst_code": "082",
//         "enaira_bank_code": "keystone",
//         "relationship_bank": "Keystone Bank",
//         "wallet_info": {
//             "tier": "2",
//             "nuban": "1000021242",
//             "message": "Created successfully",
//             "wallet_alias": "@eonuoha.01",
//             "wallet_address": "01G5P2NYVBPBK362FJK6X682CS",
//             "daily_tnx_limit": "200000.00"
//         },
//         "password": "4cf03413139f02046c0c4ddb559790ef",
//         "referrers_code": null
//     }
// }'