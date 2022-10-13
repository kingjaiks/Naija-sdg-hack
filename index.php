<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	<title>TE-N - Tokenized e-Wallet</title>
</head>
<body>
	<section class="container">
		<header>
			<div class="headerSec">
				<img src="images/enaira-logo-bw.png" width="70px">
			</div>
			<div class="headerSec">
				<h1>TE-N</h1>
				<p>Tokenization</p>
			</div>
			<div class="clr"></div>
		</header>

		<div class="mainBody">
			<div class="slider">
				<div class="slideFilter">
					<h1>Project TE-N</h1>
					<p style=" color: #333; line-height:2em">Payments made easier and safer with <b>simple-tokens</b>.use the buttons below to get started.</p> <br><br>
					<?php 
						if(isset($_SESSION['id'])){ ?>
					<a href="account.php" class="linkButton">My Dashboard</a>
						<?php } else { ?>
					<a href="signup.php" class="linkButton">Signup</a>
					<a href="login.php" class="linkButton">Login</a>
						<?php }
					?>
				</div>
			</div>
		</div>
		<div class="clr"></div>

		<div class="dualDisplaySection" style="padding:0 ">
			<!-- <h1 class="mainHeading" style="padding:3px 10px">Get Loan Token</h1> -->
			<img src="images/market-woman.jpg" width="100%">
		</div>

		<div class="dualDisplaySection" style="padding:0;">
			<h1 class="mainHeading" style="padding:3px 10px; margin:0;">Quick Loans</h1>
			<p style="margin: 0 10px;">Get quick loans for SMEs and NANO Business owners. No documents or colateral required. How to access it:
				<ul style="line-height: 2em; margin-top: 0;">
					<li>Generate a token</li>
					<li>Copy down the <b><em>simple-readable-token</em></b></li>
					<li>Take to the nearest accredited POS Agent/Out-Lets and cahsout</li>
				</ul>
			</p>
			<form style="padding: 5px; border: 1px solid limegreen; margin: 5px 5%; width: 90%;">
				<p id="chkMsg" style="font-size: 12px; margin: 0; padding: 8px; background: #ffe; color: brown; font-weight:bold; text-align:center; display: none;"></p>
				<input type="number" name="amount" placeholder="Phone Number" id="phone">
				<input type="number" name="amount" placeholder="Loan Amount" id="amount">
				<button type="button" id="generateTokenBtn">Generate</button>
			</form>
		</div>

		<div class="clr"></div>
		<br><br><br>
		<footer>
			<p>Tokenization by <b><em>Digital Economy Team</em></b></p>
		</footer>
	</section>




<script type="text/javascript">
	document.getElementById('generateTokenBtn').addEventListener('click', function(){
		let phone = document.getElementById('phone');
		let amount = document.getElementById('amount');
		let msg = document.getElementById('chkMsg');
		
		if(phone.textLength < 11){
			msg.innerText = 'Please enter a valid phone number';
			msg.style.color = '#990000';
			msg.style.background = '#fecefe';
			msg.style.display = 'block';
			phone.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				phone.style.border = 'none';
			}, 3000);
		}
		else if(amount.value <= 0){
			msg.innerText = 'Please enter loan amount';
			msg.style.color = '#990000';
			msg.style.background = '#fecefe';
			msg.style.display = 'block';
			amount.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				amount.style.border = 'none';
			}, 3000);
		}
		else {
			msg.innerHTML = "Generating <i class='fa fa-spinner fa-spin'></i>";
			msg.style.color = 'green';
			msg.style.background = '#cefece';
			msg.style.display = 'block';

			let postData = "generateLoanToken=true&phone="+phone.value+"&amount="+amount.value;
			let xhr = new XMLHttpRequest;
				xhr.open('POST', 'funcs/generate.php', true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						// console.log(xhr.responseText);
						let response = JSON.parse(xhr.responseText);
						if(response.status == 200){
							msg.innerText = 'Token: '+ response.token;
							msg.style.background = '#cefece';
							msg.style.color = 'green';
						} else {
							msg.innerText = response.msg;
							msg.style.color = '#990000';
							msg.style.background = '#fecefe';
						}
					}

				}
				xhr.send(postData);
		}
	});


</script>
</body>
</html>