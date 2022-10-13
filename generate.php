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

if(isset($_POST['generateToken'])){
	$title = textFilter($_POST['title']);
	$amount = textFilter($_POST['amount']);
	$type = textFilter($_POST['type']);

	if($type == 'Debit'){
		$codeGen = uniqid('DrTkn.',true);
	} else {
		$codeGen = uniqid('CrTkn.',true);
	}
	$codeGet = explode('.', $codeGen);
	$code = $codeGet[0].$codeGet[2];

	$sql = "INSERT INTO `tokens`(`token_title`, `token_code`, `token_type`, `token_user`, `token_amount`, `token_bal`, `token_date`) VALUES('$title', '$code', '$type', '$activeUser', '$amount', '$amount', '$gtDate')";
	if($getDbData->dbQuery($sql) == 1){
		$response = array('status' => '200', 'msg' => 'Token generated', 'token' => $code);
	} else {
		$response = array('status' => '300', 'msg' => 'Unable to generate token, please try again');
	}
	echo json_encode($response);
}

elseif(isset($_POST['generateLoanToken'])){
	$phone = textFilter($_POST['phone']);
	$amount = textFilter($_POST['amount']);
	$type = 'Loan';

	if($type == 'Debit'){
		$codeGen = uniqid('DrTkn.',true);
	}
	elseif($type == 'Loan'){
		$codeGen = uniqid('LoTkn.',true);
	} else {
		$codeGen = uniqid('CrTkn.',true);
	}

	$codeGet = explode('.', $codeGen);
	$code = $codeGet[0].$codeGet[2];

	$sql = "INSERT INTO `tokens`(`token_title`, `token_code`, `token_type`, `token_user`, `token_amount`, `token_bal`, `token_date`) VALUES('$phone', '$code', '$type', 'Admin', '$amount', '$amount', '$gtDate')";
	if($getDbData->dbQuery($sql) == 1){
		$sql = "INSERT INTO `loans`(`loan_token`, `loan_phone`) VALUES('$code', '$phone')";
		$getDbData->dbQuery($sql);
		$response = array('status' => '200', 'msg' => 'Token generated', 'token' => $code);
	} else {
		$response = array('status' => '300', 'msg' => 'Unable to generate token, please try again');
	}
	echo json_encode($response);
}

else{
	$sql = "SELECT * from tokens where token_user = '$activeUser' order by token_id desc; ";
	if($getDbData->queryCount($sql) > 0){
		$tokens = $getDbData->multiple($sql);
		foreach($tokens as $token){ ?>
			<div class="fullDisplaySection" style="position:relative; padding: 5px; border-left:<?php if($token['token_type'] == 'Debit'){ echo '5px solid red'; } else {echo '5px solid green';} ?>">
				<a href="?tokeninfo=true&token=<?php echo $token['token_code']; ?>" style="margin: 0; font-size:20px; color: green; font-size: 16px; text-decoration:none; "> <?php echo $token['token_code']; ?> | <small style="color: #333; font-size: 12px;">
					<?php echo shortTextDisplay($token['token_title']); ?>
				</small> </a>
				<p style="font-size: 12px; font-style: italic; margin: 0;">
					Type: <?php
						if($token['token_type'] == 'Debit'){
							echo "<span style='color:red'>Debit Transactions Only</span>";
						} else {
							echo "<span style='color:green'>Credit Transactions Only</span>";
						}
					?>
					Date:<?php echo $token['token_date']; ?>
						
				</p>
				<?php 
					if($token['token_status'] == 0){ ?>
				<div class="status" style="position: absolute; right: 10px; top: 5px; border-radius: 5px; background: #fecefe; color: #990000; font-size: 12px; padding: 7px 10px;">Disabled</div>
					<?php } 
					elseif($token['token_status'] == 1){ ?>
				<div class="status" style="position: absolute; right: 10px; top: 5px; border-radius: 5px; background: #cefece; color: green; font-size: 12px; padding: 7px 10px;">Active</div>
					<?php } else { ?>
				<div class="status" style="position: absolute; right: 10px; top: 5px; border-radius: 5px; background: #ffb; color: #990000; font-size: 12px; padding: 7px 10px;">Exhusted</div>
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