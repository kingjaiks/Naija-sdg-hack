<?php

// SITE FORM FUNCTIONS // Built at Averise Web Solutions Kaduna 08186870849 or 09072219905
// external resources and customised library
session_start();
include '../../funcs/bsf.php';
include '../../funcs/lib.php';
// basic library clases
$getDbData = new getDbData;
$accountHandle = new accountHandle;
$postData = new postData;
$userData = new userData;

###############################################

// main code begines


// removing image
if(isset($_GET['imageDelete'])){
	$sr = $_GET['imageDelete'];
	$sql = "SELECT * from family_gallery where file_code = '$sr'; ";
	$count = $getDbData->queryCount($sql);
	if($count > 0){
		$fileData = $getDbData->single($sql);
		$family = $fileData['file_family'];
		$sql = "DELETE from family_gallery where file_code = '$sr'; ";
		if($getDbData->dbQuery($sql) == '1'){
			$path = '../../images/uploads/'.$fileData['file_name'];
			unlink($path);
			header("Location: ../?viewfamilies=$family&msg=Image Removed");
			echo "<script type='text/javascript'>window.top.location='../?viewfamilies=$family&msg=Image Removed';</script>";
			exit();
		} else {
			header("Location: ../?viewfamilies=$family&msg=Unable to Remove Image");
			echo "<script type='text/javascript'>window.top.location='../?viewfamilies=$family&msg=Unable to Remove Image';</script>";
			exit();
		}
	}
}

// removing image
if(isset($_GET['memberDelete'])){
	$sr = $_GET['memberDelete'];
	$sql = "SELECT * from family_members where mem_code = '$sr'; ";
	$count = $getDbData->queryCount($sql);
	if($count > 0){
		$fileData = $getDbData->single($sql);
		$family = $fileData['mem_family'];
		$sql = "DELETE from family_members where mem_code = '$sr'; ";
		if($getDbData->dbQuery($sql) == '1'){
			$path = '../../images/uploads/'.$fileData['mem_image'];
			unlink($path);
			header("Location: ../?viewfamilies=$family&msg=Member Removed");
			echo "<script type='text/javascript'>window.top.location='../?viewfamilies=$family&msg=Member Removed';</script>";
			exit();
		} else {
			header("Location: ../?viewfamilies=$family&msg=Unable to Remove Member");
			echo "<script type='text/javascript'>window.top.location='../?viewfamilies=$family&msg=Unable to Remove Member';</script>";
			exit();
		}
	}
}
