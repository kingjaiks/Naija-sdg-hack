<?php

// external essential resources
session_start();
include 'bsf.php';
include 'lib.php';

$getDbData = new getDbData;
$accountHandle = new accountHandle;
$userData = new userData;

#######################################################################################
// Handeling login activities

	if(isset($_POST['login'])){

	$formData = explode('|||', $_POST['login']);
	$userId = textFilter($formData[0]);
	$pwd = textFilter($formData[1]);

	// $userId = textFilter($_POST['userId']);
	// $pwd = textFilter($_POST['pwd']);
	// $link = "../login.php?msg=";

	$verifyUser = $accountHandle->verifyUser($userId);
	if($verifyUser == '110'){
		
		$msg = "Err: 110 - User not Found";
		echo $msg;

		// header("Location: $link$msg");
		// echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
		// exit();
	} else {
		$pwdHash = $verifyUser['user_pass'];
		$verifyPwd = $accountHandle->verifyPassword($pwd, $pwdHash);
		if($verifyPwd == '106'){

			$msg = "Err: 106 - Invalid Login Credentials";
			echo $msg;

			// header("Location: $link$msg");
			// echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
			// exit();
		} else {

			$_SESSION['id'] = $verifyUser['user_code'];
			$_SESSION['type'] = $verifyUser['user_type'];

			$msg = "200 - Login Successfull";
			echo $msg;

			// header("Location: ../");
			// echo "<script type='text/javascript'>window.top.location='../';</script>";
			// exit();
		}
	}

} 

elseif(isset($_POST['signup'])){
	$name = textFilter($_POST['name']);
	$email = textFilter($_POST['email']);
	$phone = textFilter($_POST['phone']);
	$pwd = textFilter($_POST['pwd']);
	$repwd = textFilter($_POST['repwd']);

	// checking email and phone availability
	$sql = "SELECT * from users where user_email = '$email'; ";
	if($getDbData->queryCount($sql) > 0){
		echo "300 - Email address already in use!";
	} else {
		$sql = "SELECT * from users where user_phone = '$phone'; ";
		if($getDbData->queryCount($sql) > 0){
			echo "300 - Phone number already in use!";
		} else {
			$code = uniqid('ayigbo_user_', false);
			$passwordCheck = $accountHandle->makePassword($pwd, $repwd);

			if($passwordCheck == '105'){
				echo "300 - Passwords do not match!";
			} elseif($passwordCheck == '104'){
				echo "300 - Password must be 5 Characters above ";
			} else {
				// saving file name to DB
				$userType = 'User';

				$sql = "INSERT INTO `users`(`user_fullname`, `user_email`, `user_phone`, `user_type`, `user_pass`, `user_status`, `user_code`) VALUES ('$name','$email', '$phone', '$userType', '$passwordCheck', '0', '$code'); ";
				$query = $getDbData->dbquery($sql);

				if($query == '1'){

					$_SESSION['id'] = $code;
					$_SESSION['type'] = $userType;

					echo "200 - User Account created successfully";
				} else {
					echo "300 -  Unable to create your account";
				}
			}
		}
	}

}


elseif(isset($_POST['request'])){
	$userId = textFilter($_POST['userid']);
	$sql = "SELECT * from users where user_email = '$userId' or user_phone = '$userId'; ";
	if($getDbData->queryCount($sql) > 0){

		$userData = $getDbData->single($sql);

		$name = $userData['user_fullname'];
		$email = $userData['user_email'];
		$userCode = $userData['user_code'];

		$code = uniqid('ayigbo.pwd.reset.code', true);
		$token = uniqid('ayigbo.pwd.reset.token', true);
		$resetLink = "https://ayigbo.com/account/login/reset.php?i=$code&v=$token";
		$exp = date('U') + 1800;

		// Checking for active Request link
		$sql = "SELECT from password_reset where reset_user = '$userCode'; ";
		if($getDbData->queryCount($sql) > 0){
			$requestData = $getDbData->single($sql);
			if($requestData['reset_exp'] < date("U")){

				// delete active reset record
				$sql = "DELETE from password_reset where reset_user = '$userCode'; ";
				$getDbData->dbquery($sql);

				if(sendResetMail($name, $email, $resetLink) == 'sent'){
					if(populateRequestDB() == 'ok'){
						echo "200 - Mail sent to $email";
					} else{
						echo "300 - Error occured, please try again in 15mins time.";
					}
				} else{
					echo "300 - Unable to send email, try again.";
				}

			} else {
				echo "300 - Use the link sent to your email or wait a little longer to request again.";
			}

		} else {
			if(sendResetMail($name, $email, $resetLink) == 'sent'){
				if(populateRequestDB() == 'ok'){
					echo "200 - Mail sent to $email";
				} else{
					echo "300 - Error occured, please try again in 15mins time.";
				}
			} else{
				echo "300 - Unable to send email, try again.";
			}
		}


		function populateRequestDB(){
			$sql = "INSERT into `password_reset`(`reset_user_account`, `reset_token`, `reset_code`, `reset_exp`, `reset_status`) VALUES('$userCode', '$token', '$code', '$exp', 'active'); ";
			if($getDbData->dbQuery($sql) == '1'){
				return 'ok';
			}else{
				return 'failed';
			}

		}


	} else {
		echo "300 - no user found with provided identifyer";
	}
	
}

elseif(isset($_POST['reset'])){

	$token = textFilter($_POST['token']);
	$code = textFilter($_POST['code']);
	$pwd = textFilter($_POST['pwd']);
	$repwd = textFilter($_POST['repwd']);

	// checking for active request and validating link
	$sql = "SELECT * from password_reset where reset_code = '$code' AND reset_token = '$token'; ";
	if($getDbData->queryCount($sql) > 0){
		$resetData = $getDbData->single($sql);
		$resetUser = $resetData['reset_user_account'];
		if($resetData['reset_exp'] > date("U")){

			$passwordCheck = $accountHandle->makePassword($pwd, $repwd);

			if($passwordCheck == '105'){
				echo "300 - Passwords do not match!";
			} elseif($passwordCheck == '104'){
				echo "300 - Password must be 5 Characters above ";
			} else {
				// saving file name to DB
				$userType = 'User';

				$sql = "UPDATE `users` set `user_pass` = '$passwordCheck' where user_code = '$resetUser'; ";
				$query = $getDbData->dbquery($sql);

				if($query == '1'){
					echo "200 - Password Changed successfully";
				} else {
					echo "300 -  Unable to Change Password";
				}
			}

		} else {
			echo '300 - Link Expired, please request a new recovery link';
		}
	}else {
		echo '300 - Invalid link, Please make sure you follow the link sent to your email correctly';
	}

	
}

else {
	header("Location: ../");
	echo "<script type='text/javascript'>window.top.location='../';</script>";
	exit();
}



