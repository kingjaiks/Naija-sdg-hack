<h1 class="mainHeading">Connect</h1>
<p style="font-size: 12px;">Connect and link to your e-Wallet wallet directly.</p>

<div class="fullDisplaySection">
	<h3>e-Wallet Connection</h3>
	<p  id="chkMsg" style="font-size: 12px; font-weight: bold;">error message </p>
	<form>
		<input type="text" placeholder="Enter email"  id="userIdentifyer">
		<input type="password" placeholder="Enter password"  id="userpass">
		<button class="boxBtn" id="chkBtn" type="button">Connect to Wallet</button>
	</form>
</div>


<script type="text/javascript">
	document.getElementById('chkBtn').addEventListener('click', function(){
		let userId = document.getElementById('userIdentifyer');
		let password = document.getElementById('userpass');
		let msg = document.getElementById('chkMsg');
		
		if(userId.value == '' || userId.value == ' '){
			msg.innerText = 'Please enter your email address';
			msg.style.color = '#ff0000';
			userId.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				userId.style.border = 'none';
			}, 3000);
		}  
		else if(userpass.value == '' || userpass.value == ' '){
			msg.innerText = 'Please type in your password';
			msg.style.color = '#ff0000';
			userpass.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				userpass.style.border = 'none';
			}, 3000);

		}
		else {
			processCheks();
		} 
		
		function processCheks(){
			msg.innerText = 'Connecting... Please wait';
			msg.style.color = 'green';
			let postData = "walletLogin=true&user="+userId.value+'&pass='+userpass.value;
			let xhr = new XMLHttpRequest;
				xhr.open('POST', 'funcs/userLogin.php', true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						console.log(xhr.responseText);
						// let response = JSON.parse(xhr.responseText);
					}

				}
				xhr.send(postData);
		}
	});
</script>


<div class="clr"></div>