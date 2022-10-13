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

// ===================================================


if(isset($_POST['personInfo'])){
  $token = textFilter($_POST['personInfo']);
  $name = textFilter($_POST['name']);
  $phone = textFilter($_POST['phone']);
  $nin = textFilter($_POST['nin']);
  $biztype = textFilter($_POST['biztype']);
  $bizDesc = textFilter($_POST['bizDesc']);
  $sql = "SELECT * from loans where loan_token = '$token' ";
  if($getDbData->queryCount($sql) > 0){
    $sql = "UPDATE loans set loan_name = '$name', loan_phone = '$phone', loan_nin = '$nin', loan_biz = '$biztype', loan_desc = '$bizDesc' where loan_token = '$token' ";
    if($getDbData->dbQuery($sql) == 1){
      $response = array('status' => '200', 'msg' => 'Personal Information Saved.');
    } else {
      $response = array('status' => '300', 'msg' => 'Request Failed, Try again.');
    }
  } else {
    $response = array('status' => '300', 'msg' => 'Unexpected Error, please relod the page and retry.');
  }
  echo json_encode($response);
}

elseif(isset($_POST['loanAddress'])){
  $token = textFilter($_POST['loanAddress']);
  $building = textFilter($_POST['building']);
  $street = textFilter($_POST['street']);
  $town = textFilter($_POST['town']);
  $state = textFilter($_POST['state']);
  $sql = "SELECT * from loans where loan_token = '$token' ";
  if($getDbData->queryCount($sql) > 0){
    $sql = "UPDATE loans set loan_building = '$building', loan_street = '$street', loan_town = '$town', loan_state = '$state' where loan_token = '$token'; ";
    if($getDbData->dbQuery($sql) == 1){
      $response = array('status' => '200', 'msg' => 'Business Address Saved.');
    } else {
      $response = array('status' => '300', 'msg' => 'Request Failed, Try again.');
    }
  } else {
    $response = array('status' => '300', 'msg' => 'Unexpected Error, please relod the page and retry.');
  }
  echo json_encode($response);
}

elseif(isset($_POST['loanSubmit'])){
  $token = textFilter($_POST['loanSubmit']);
  $userName = $userData->fullName($activeUser);
  $agree = "By submitting, I <b><em>$userName</em></b> agree on $gtDate that i will repay this loan if it goes wrong.";
  $sql = "SELECT * from loans where loan_token = '$token' ";
  if($getDbData->queryCount($sql) > 0){
    $bzData = $getDbData->single($sql);
    if(!empty($bzData['loan_phone']) && !empty($bzData['loan_nin']) && !empty($bzData['loan_state']) && !empty($bzData['loan_town'])){
      $sql = "UPDATE loans set loan_agree = '$agree', loan_status = '2', loan_date = '$gtDate', loan_user = '$activeUser' where loan_token = '$token'; ";
      if($getDbData->dbQuery($sql) == 1){
        $response = array('status' => '200', 'msg' => 'Loan Submitted Successfully.');
      } else {
        $response = array('status' => '300', 'msg' => 'Request Failed, Try again.');
      }
    } else {
      $response = array('status' => '300', 'msg' => 'Please fillout and save the entire form befor submiting.');
    }
  } else {
    $response = array('status' => '300', 'msg' => 'Unexpected Error, please relod the page and retry.');
  }
  echo json_encode($response);
}

elseif(isset($_POST['updateLoan'])){
  $token = textFilter($_POST['updateLoan']);
  $status = textFilter($_POST['status']);
  $sql = "SELECT * from loans where loan_token = '$token' ";
  if($getDbData->queryCount($sql) > 0){
    $sql = "UPDATE loans set loan_status = '$status' where loan_token = '$token'; ";
    if($getDbData->dbQuery($sql) == 1){
      $response = array('status' => '200', 'msg' => 'Loan Updated Successfully.');
    } else {
      $response = array('status' => '300', 'msg' => 'Request Failed, Try again.');
    }
  } else {
    $response = array('status' => '300', 'msg' => 'Unexpected Error, please relod the page and retry.');
  }
  echo json_encode($response);
}

// ===============================================

elseif(isset($_POST['bizInfo'])){
  $name = textFilter($_POST['name']);
  $phone = textFilter($_POST['phone']);
  $email = textFilter($_POST['email']);
  $reg = textFilter($_POST['reg']);
  $desc = textFilter($_POST['desc']);
  $sql = "SELECT * from vendors where biz_user = '$activeUser' ";
  if($getDbData->queryCount($sql) > 0){
    $sql = "UPDATE vendors set biz_name = '$name', biz_phone = '$phone', biz_email = '$email', biz_reg = '$reg', biz_desc = '$desc' where biz_user = '$activeUser'; ";
    if($getDbData->dbQuery($sql) == 1){
      $response = array('status' => '200', 'msg' => 'Business Information Saved.');
    } else {
      $response = array('status' => '300', 'msg' => 'Request Failed, Try again.');
    }
  } else {
    $response = array('status' => '300', 'msg' => 'Unexpected Error, please relod the page and retry.');
  }
  echo json_encode($response);
}

elseif(isset($_POST['bizAccount'])){
  $bvn = textFilter($_POST['bvn']);
  $bank = textFilter($_POST['bank']);
  $acc = textFilter($_POST['acc']);
  $accName = textFilter($_POST['accName']);
  $sql = "SELECT * from vendors where biz_user = '$activeUser' ";
  if($getDbData->queryCount($sql) > 0){
    $sql = "UPDATE vendors set biz_bvn = '$bvn', biz_bank = '$bank', biz_acc_number = '$acc', biz_acc_name = '$accName' where biz_user = '$activeUser'; ";
    if($getDbData->dbQuery($sql) == 1){
      $response = array('status' => '200', 'msg' => 'Business Account Saved.');
    } else {
      $response = array('status' => '300', 'msg' => 'Request Failed, Try again.');
    }
  } else {
    $response = array('status' => '300', 'msg' => 'Unexpected Error, please relod the page and retry.');
  }
  echo json_encode($response);
}

elseif(isset($_POST['bizAddress'])){
  $building = textFilter($_POST['building']);
  $street = textFilter($_POST['street']);
  $town = textFilter($_POST['town']);
  $state = textFilter($_POST['state']);
  $sql = "SELECT * from vendors where biz_user = '$activeUser' ";
  if($getDbData->queryCount($sql) > 0){
    $sql = "UPDATE vendors set biz_building = '$building', biz_street = '$street', biz_town = '$town', biz_state = '$state' where biz_user = '$activeUser'; ";
    if($getDbData->dbQuery($sql) == 1){
      $response = array('status' => '200', 'msg' => 'Business Address Saved.');
    } else {
      $response = array('status' => '300', 'msg' => 'Request Failed, Try again.');
    }
  } else {
    $response = array('status' => '300', 'msg' => 'Unexpected Error, please relod the page and retry.');
  }
  echo json_encode($response);
}

elseif(isset($_POST['bizSubmit'])){
  $agree = textFilter($_POST['agree']);
  $sql = "SELECT * from vendors where biz_user = '$activeUser' ";
  if($getDbData->queryCount($sql) > 0){
  	$bzData = $getDbData->single($sql);
  	if(!empty($bzData['biz_phone']) && !empty($bzData['biz_bvn']) && !empty($bzData['biz_state']) && !empty($bzData['biz_town'])){
	    $sql = "UPDATE vendors set biz_agree = '$agree', biz_status = '2', biz_date = '$gtDate' where biz_user = '$activeUser'; ";
	    if($getDbData->dbQuery($sql) == 1){
	      $response = array('status' => '200', 'msg' => 'Loan Vendor Application Submitted Successfully.');
	    } else {
	      $response = array('status' => '300', 'msg' => 'Request Failed, Try again.');
	    }
  	} else {
	    $response = array('status' => '300', 'msg' => 'Please fillout and save the entire form befor submiting.');
  	}
  } else {
    $response = array('status' => '300', 'msg' => 'Unexpected Error, please relod the page and retry.');
  }
  echo json_encode($response);
}


else{
  $sql = "SELECT * from loans where loan_user = '$activeUser' order by loan_id desc; ";
  if($getDbData->queryCount($sql) > 0){
    $loans = $getDbData->multiple($sql);
    foreach($loans as $loan){ 
      $token = $loan['loan_token'];
      $sql = "SELECT * from tokens where token_code = '$token' ";
      $tokenData = $getDbData->single($sql);
      ?>
      <div class="fullDisplaySection" style="position:relative; padding: 5px; border-left:<?php if($loan['loan_payment'] == '0'){ echo '5px solid red'; } else { echo '5px solid green';} ?>">
        <a href="?tokeninfo=true&token=<?php echo $loan['loan_token']; ?>" style="margin: 0; font-size:20px; color: green; font-size: 16px; text-decoration:none; "> <?php echo shortTextDisplay($loan['loan_name']); ?> | <small style="color: #333; font-size: 12px;">
          <?php echo shortTextDisplay($loan['loan_phone']); ?>
        </small> </a>
        <p style="font-size: 12px; font-style: italic; margin: 0;">
          Loan Aaount: <?php echo $tokenData['token_amount']; ?>
          Date:<?php echo $loan['loan_date']; ?>
            
        </p>
        <?php 
          if($loan['loan_payment'] == 0){ ?>
        <div class="status" style="position: absolute; right: 10px; top: 5px; border-radius: 5px; background: #fecefe; color: #990000; font-size: 12px; padding: 7px 10px;">Not Paid</div>
          <?php } 
          elseif($loan['loan_payment'] == 1){ ?>
        <div class="status" style="position: absolute; right: 10px; top: 5px; border-radius: 5px; background: #cefece; color: green; font-size: 12px; padding: 7px 10px;">Paid</div>
          <?php } else { ?>
        <div class="status" style="position: absolute; right: 10px; top: 5px; border-radius: 5px; background: #ffb; color: #990000; font-size: 12px; padding: 7px 10px;">Pending</div>
          <?php }
        ?>
      </div>
    <?php }
  } else { ?>

  <p style="margin: 10px; font-size: 30px; color: #ddd; line-height:2em;">
  <i class="fa fa-times" style="font-size:70px;"></i><br>
  No tokens created yet.
  </p>

  <?php }
}