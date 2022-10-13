<?php
// SITE FORM FUNCTIONS // Built at Averise Web Solutions Kaduna 08186870849 or 09072956764
// external resources and customised library
session_start();
include 'bsf.php';
include 'lib.php';
// basic library clases
$getDbData = new getDbData;
$accountHandle = new accountHandle;
$userData = new userData;
$activeUser = $_SESSION['id'];
$gtDate = date("D j M, Y");

if(isset($_POST['getFunds'])){

  $token = textFilter($_POST['token']);
  $amt = textFilter($_POST['amt']);

  $sql = "SELECT * from tokens where token_code = '$token' ";
  if($getDbData->queryCount($sql) > 0){
    $tokenData = $getDbData->single($sql);
    if($tokenData['token_user'] == $activeUser){
      $response = array('status' => '300', 'msg' => 'SELF GENERATED TOKEN: You cant utilize a token you generated.');
    } else {
      if($tokenData['token_type'] == 'Debit'){
        if($tokenData['token_status'] == '1'){
          if($tokenData['token_bal'] >= $amt){
            // $response = array('status' => '200', 'msg' => 'INSUFFICIENT FUNDS: Token do not have enough funds allocation for this payment.');
          } else {
            $response = array('status' => '300', 'msg' => 'LIMIT REACHED: Token do not have enough funds allocation.');
          }
        } else {
          $response = array('status' => '300', 'msg' => 'BLOCKED / DEACTIVATED: Token has been deactivated.');
        }
      } else {
        $response = array('status' => '300', 'msg' => 'CREDIT TOKEN: This token is meant to recieve funds only, please use a DEBIT TOKEN to recieve payments.');
      }
    }
  } else {
    $response = array('status' => '300', 'msg' => 'INVALID TOKEN: Please ensure you entered a correct token.');
  }
  echo json_encode($response);
}


if(isset($_POST['payFunds'])){

  $token = textFilter($_POST['token']);
  $amt = textFilter($_POST['amt']);

  $sql = "SELECT * from tokens where token_code = '$token' ";
  if($getDbData->queryCount($sql) > 0){
    $tokenData = $getDbData->single($sql);
    if($tokenData['token_user'] == $activeUser){
      $response = array('status' => '300', 'msg' => 'SELF GENERATED TOKEN: You cant utilize a token you generated.');
    } else {
      if($tokenData['token_type'] == 'Credit'){
        if($tokenData['token_status'] == '1'){
          if($amt <= $tokenData['token_amount'] ){
            // $response = array('status' => '200', 'msg' => 'INSUFFICIENT FUNDS: Token do not have enough funds allocation for this payment.');
          } else {
            $response = array('status' => '300', 'msg' => 'LIMIT REACHED: Amount is more than this token can payout.');
          }
        } else {
          $response = array('status' => '300', 'msg' => 'BLOCKED / DEACTIVATED: Token has been deactivated.');
        }
      } else {
        $response = array('status' => '300', 'msg' => 'DEBIT TOKEN: This token is meant to pay/transfer funds only, please use a CREDIT TOKEN to make payments.');
      }
    }
  } else {
    $response = array('status' => '300', 'msg' => 'INVALID TOKEN: Please ensure you entered a correct token.');
  }
  echo json_encode($response);
}

if(isset($_POST['disableToken'])){

  $token = textFilter($_POST['token']);
  $sql = "SELECT * from tokens where token_code = '$token' ";
  if($getDbData->queryCount($sql) > 0){
    $sql = "UPDATE tokens set token_status = 0 where token_code = '$token'; ";
    if($getDbData->dbQuery($sql) == 1){
      $response = array('status' => '200', 'msg' => 'Token Disabled.');
    } else {
      $response = array('status' => '300', 'msg' => 'Request Failed.');
    }
  } else {
    $response = array('status' => '300', 'msg' => 'INVALID TOKEN: Please ensure you entered a correct token.');
  }
  echo json_encode($response);
}


if(isset($_POST['enableToken'])){

  $token = textFilter($_POST['token']);
  $sql = "SELECT * from tokens where token_code = '$token' ";
  if($getDbData->queryCount($sql) > 0){
    $sql = "UPDATE tokens set token_status = 1 where token_code = '$token'; ";
    if($getDbData->dbQuery($sql) == 1){
      $response = array('status' => '200', 'msg' => 'Token Enabled.');
    } else {
      $response = array('status' => '300', 'msg' => 'Request Failed.');
    }
  } else {
    $response = array('status' => '300', 'msg' => 'INVALID TOKEN: Please ensure you entered a correct token.');
  }
  echo json_encode($response);
}

if(isset($_POST['getTrans'])){

  $token = textFilter($_POST['token']);
  $sql = "SELECT * from transactions where trans_token = '$token' and trans_user = '$activeUser' ";
  if($getDbData->queryCount($sql) > 0){
    $tokenData = $getDbData->wultiple($sql);
    foreach($tokenData as $newToken){
      echo $newToken['token_title'];
    }
  } else { ?>

    <p style="margin: 10px; font-size: 30px; color: #ddd; line-height:2em;">
      <i class="fa fa-times" style="font-size:70px;"></i><br>
      No transactions performed with this token yet.
    </p>

  <?php }
  // echo json_encode($response);
}