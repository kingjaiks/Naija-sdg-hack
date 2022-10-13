<?php

// SITE FORM FUNCTIONS // Built at Averise Web Solutions Kaduna 08186870849 or 09072956764
// external resources and customised library
session_start();
include 'bsf.php';
include 'lib.php';
// basic library clases
$getDbData = new getDbData;
$accountHandle = new accountHandle;
$postData = new postData;
$userData = new userData;

$gtDate = date("D j M, Y");

###############################################

// main code begines

// updating account phone
if(isset($_POST['updatePassword'])){

	$oldPass = textFilter($_POST['oldpass']);
	$reOldPass = textFilter($_POST['reoldpass']);

	$newPass = textFilter($_POST['newpass']);
	$reNewPass = textFilter($_POST['renewpass']);

	if($oldpass == ' ' || $reOldPass == ' ' || $newPass == ' ' || $reNewPass == ' '){
		$msg = "You skipped some things";
		header("Location: ../?profile&msg=$msg");
		echo "<script type='text/javascript'>window.top.location='../?profile&msg=$msg';</script>";
		exit();
	} else {
		if($oldPass !== $reOldPass){
			$msg = "Old Passwords do not match";
			header("Location: ../?profile&msg=$msg");
			echo "<script type='text/javascript'>window.top.location='../?profile&msg=$msg';</script>";
			exit();
		} else {
			$dbPass = $userData->pass($_SESSION['id']);
			if($accountHandle->verifyPassword($reOldPass, $dbPass) == 'ok'){
				$newAccPassword = $accountHandle->makePassword($newPass, $reNewPass);
				
				if($newAccPassword == '104'){
					$msg = "Password must be above 4 Characters";
					header("Location: ../?profile&msg=$msg");
					echo "<script type='text/javascript'>window.top.location='../?profile&msg=$msg';</script>";
					exit();
				}

				elseif($newAccPassword == '105'){
					$msg = "New Passwords do not match";
					header("Location: ../?profile&msg=$msg");
					echo "<script type='text/javascript'>window.top.location='../?profile&msg=$msg';</script>";
					exit();
				}

				else {
					$newHashPassword = $newAccPassword;
					$userTar = $_SESSION['id'];
					$sql = "UPDATE users set user_pass = '$newHashPassword' where user_code = '$userTar'; ";
					$query = $getDbData->dbquery($sql);
					if($query == '1'){
						$msg = "Account Password Updated";
						header("Location: ../?profile&msg=$msg");
						echo "<script type='text/javascript'>window.top.location='../?profile&msg=$msg';</script>";
					exit();
					} else {
						$msg = " Unable Update Account Password";
						header("Location: ../?profile&msg=$msg");
						echo "<script type='text/javascript'>window.top.location='../?profile&msg=$msg';</script>";
					exit();
					}	

				}
			} else {
				$msg = "Old Password Incorrect";
				header("Location: ../?profile&msg=$msg");
				echo "<script type='text/javascript'>window.top.location='../?profile&msg=$msg';</script>";
					exit();
			}
		}
	}	
}

if(isset($_POST['updateProfileImg'])){

	$img = $_FILES['profileImg'];
	$currentUser = $_SESSION['id'];
	$sql = "SELECT * from users where user_code = '$currentUser'; ";
	$count = $getDbData->queryCount($sql);
	$link = "../?profile=$family&msg=";
	
	if($count > 0){

		$imgName = $getDbData->queryFetch($sql);

		if(!empty($imgName['user_image'])){

			$saveImg = $getDbData->replaceUpload($img, $imgName['user_image']);
			// 111 | File Upload Error!
			// 112 | Sizes too Big
			// 113 | Temporal upload Error!
			// 114 | Not allowed file type!
			switch ($saveimg) {
				case '111':
					$msg = "Err: 111 - File Upload Error!";
					header("Location: $link$msg");
					echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
					break;
				
				case '112':
					$msg = "Err: 112 - Sizes too Big";
					header("Location: $link$msg");
					echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
					break;
				
				case '113':
					$msg = "Err: 113 - Temporal upload Error!";
					header("Location: $link$msg");
					echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
					break;
				
				case '114':
					$msg = "Err: 114 - Not allowed file type!";
					header("Location: $link$msg");
					echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
					break;
				
				default:
					$msg = "File Replaced";
					header("Location: $link$msg");
					echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
					break;
			}
		} else{
			// $code = uniqid('ayigbo_slider_img_', false);
			$saveimg = $getDbData->fileUpload($img);
			switch ($saveimg) {
				case '111':
					$msg = "Err: 111 - File Upload Error!";
					header("Location: $link$msg");
					echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
					break;
				
				case '112':
					$msg = "Err: 112 - Sizes too Big";
					header("Location: $link$msg");
					echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
					break;
				
				case '113':
					$msg = "Err: 113 - Temporal upload Error!";
					header("Location: $link$msg");
					echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
					break;
				
				case '114':
					$msg = "Err: 114 - Not allowed file type!";
					header("Location: $link$msg");
					echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
					break;
				
				default:

					// saving file name to DB
					$imgSaveData = explode(" | ", $saveimg);

					$imgname = $imgSaveData[0];
					$imgType = $imgSaveData[1];

					$sql = "UPDATE users set `user_image`= '$imgname' where `user_code` =  '$currentUser'; ";
					$query = $getDbData->dbquery($sql);

					if($query == '1'){
						$msg = "Image Uploaded";
						header("Location: $link$msg");
						echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
						exit();
					} else {
						$path = "../../images/uploads/".$imgname;
						unlink($path);
						$msg = " Unable to Upload File";
						header("Location: $link$msg");
						echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
						exit();
					}
					break;
			}

		}
	}
}

if(isset($_POST['updateUser'])){
	$name = textFilter($_POST['name']);
	$email = textFilter($_POST['email']);
	$phone = textFilter($_POST['phone']);
	$state = textFilter($_POST['state']);
	$town = textFilter($_POST['town']);
	$street = textFilter($_POST['street']);
	$building = textFilter($_POST['building']);

	$user = $_SESSION['id'];
	$link = "../account.php?profile&msg=";

	$sql = "UPDATE users set user_fullname = '$name', user_email = '$email', user_phone = '$phone', user_state = '$state', user_town = '$town', user_street = '$street', user_building = '$building' where user_code = '$user'; ";
	
	if($getDbData->dbQuery($sql) == '1'){
		$msg = "Profile Updated";
		header("Location: $link$msg");
		echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
		exit();
	} else {
		$msg = " Unable to Update Profile";
		header("Location: $link$msg");
		echo "<script type='text/javascript'>window.top.location='$link$msg';</script>";
		exit();
	}

}
