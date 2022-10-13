<?php
session_start();
include 'funcs/bsf.php';
include 'funcs/lib.php';
// basic library clases
$getDbData = new getDbData;
$accountHandle = new accountHandle;
$postData = new postData;
$userData = new userData;

$gtDate = date("D j M, Y");

if(isset($_SESSION['id'])){ 
	$usr = $_SESSION['id'];
	$sql = "SELECT * from users where user_code = '$usr' ";
	$userInfo = $getDbData->single($sql);
	?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>User Dashboard</title>
</head>
<body>
	<section class="container">
		<header>
			<div class="headerSec">
				<a href="index.php">
					<img src="images/enaira-logo-bw.png" width="70px">
				</a>
			</div>
			<div class="headerSec">
				<h1>Tokenizations</h1>
				<p>User Dashboard</p>
			</div>
			<div class="clr"></div>
		</header>
		<aside class="accSec sideMenu">
			<a href="?" class="sideNavLinks">Home</a>
			<a href="?tokens" class="sideNavLinks">Tokens</a>
			<?php 
				$sql = "SELECT * from vendors where biz_user = '$usr' and biz_status = '1' ";
				if($getDbData->queryCount($sql) > 0){ ?>
			<a href="?vendor" class="sideNavLinks">Vendor</a>
				<?php }
			?>
			<a href="?pay" class="sideNavLinks">Pay</a>
			<a href="?profile" class="sideNavLinks">Profile</a>
			<a href="logout.php" class="sideNavLinks">Logout</a>
		</aside>
		<br>
		<br>
		<main class="accSec mainDisplay">
			<?php
				if(isset($_GET['pay'])){
					include 'payment.php';
				}
				elseif(isset($_GET['profile'])){
					include 'profile.php';
				}
				elseif(isset($_GET['tokens'])){
					include 'tokens.php';
				}
				elseif(isset($_GET['tokeninfo'])){
					include 'tokeninfo.php';
				}
				elseif(isset($_GET['connetuser'])){
					include 'connetuser.php';
				}
				elseif(isset($_GET['checkuser'])){
					include 'checkUser.php';
				}
				elseif(isset($_GET['newuser'])){
					include 'newuser.php';
				}
				elseif(isset($_GET['apply'])){
					include 'apply.php';
				}
				elseif(isset($_GET['vendor'])){
					include 'vendor.php';
				}
				else {
					include 'home.php';
				}
			?>
			<br>
			<div class="clr"></div>
			<br><br><br>
		</main>
		<br>
		<div class="clr"></div>
		<footer>
			<p>Tokenised <b><em>Digital Economy Team</em></b></p>
		</footer>
	</section>
</body>
</html>

<?php } else {
	header("Location: login.php");
}