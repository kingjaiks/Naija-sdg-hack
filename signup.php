<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	<title>Signup</title>
</head>
<body>
	<div class="wrapper-">
		<section class="loginContainer">
			
			<div class="dual-cols">
				<!-- emailra image in landscape
				<img src="images/enaira-flag.jpeg"> -->
				<h1>User Signup</h1>
				<p>Tokenization by <b><em>Digital Economy Team</em></b></p>
			</div>
			<div class="dual-cols">
				<p class="formMsg" id="logMsg">Error messages</p>
				<form>
					<input type="text" name="userName" id="userName" placeholder="Enter Name">
					<input type="email" name="userEmail" id="userEmail" placeholder="Enter Email">
					<input type="number" name="userPhone" id="userPhone" placeholder="Enter Phone Number">
					<input type="password" name="pwd" id="pwd" placeholder="Enter pASsw0rD">
					<input type="password" name="repwd" id="repwd" placeholder="Repeat pASsw0rD">
					<!-- <button type="submit" name="login">Login</button> -->
					<button type="button" id="signupBtn"> Signup Now <i class='fa fa-sign-in'></i></button>
				</form>
				<p>Already have your account? <a href="login.php">Login here</a></p>
			</div>
			<div class="clr"></div>
		</section>
	</div>
	<script type="text/javascript" src="js/signup-handler.js"></script>
</body>
</html>