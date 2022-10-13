<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	<title>Login</title>
</head>
<body>
	<div class="wrapper-">
		<section class="loginContainer">
			<div class="dual-cols">
				<!-- emailra image in landscape 
				<img src="images/flag.jpeg">-->
				<h1>User Login</h1>
				<p>Tokenization by <b><em>Digital Economy Team</em></b> </p>
			</div>
			<div class="dual-cols">
				<p class="formMsg" id="logMsg">Error messages</p>
				<form>
					<input type="text" name="userId" id="userId" placeholder="Enter Email or Phone Number">
					<input type="password" name="pwd" id="pwd" placeholder="Enter pASsw0rD">
					<!-- <button type="submit" name="login">Login</button> -->
					<button type="button" id="loginBtn"> Login <i class='fa fa-sign-in'></i></button>
				</form>
				<p>Need an account? <a href="signup.php">Signup here</a></p>
			</div>
			<div class="clr"></div>
		</section>
		
	</div>


	<script type="text/javascript" src="js/login-handler.js"></script>
</body>
</html>