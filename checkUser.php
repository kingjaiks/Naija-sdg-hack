<h1 class="mainHeading">Check User</h1>
<p style="font-size: 12px;">Check e-wallet details without login in.</p>

<div class="fullDisplaySection">
	<h3>Check e-Naira User</h3>
	<p  id="chkMsg" style="font-size: 12px; font-weight: bold;">error message </p>
	<form>
		<input type="text" placeholder="Enter phone / Wallet Alias"  id="userIdentifyer">
		<select id="idType" >
			<option value="">:: Checking method ::</option>
			<option value="phone">Check by Phone</option>
			<option value="alias">Check by Wallet Alias</option>
		</select> <br>
		<button class="boxBtn" id="chkBtn" type="button">Check User</button>
	</form>
</div>

<script type="text/javascript">
	document.getElementById('chkBtn').addEventListener('click', function(){
		let number = document.getElementById('userIdentifyer');
		let type = document.getElementById('idType');
		let msg = document.getElementById('chkMsg');
		if(number.value <= 0){
			number.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				number.style.border = 'none';
			}, 3000);
		} 
		else if(type.value == ''){
			msg.innerText = 'Please Select checking method ';
			msg.style.color = '#ff0000';
			type.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				type.style.border = 'none';
			}, 3000);
		}  
		else if(type.value == 'phone'){
			if(number.textLength < 11){
				msg.innerText = 'Phone number must be at least 11 characters ';
				msg.style.color = '#ff0000';
				number.style.border = '#ff0000 solid 1px';
				setTimeout(() => {
					number.style.border = 'none';
				}, 3000);
			} else {
				processCheks();
			}
		}
		else {
			processCheks();
		} 
		
		function processCheks(){
			msg.innerText = 'Processing Request...';
			msg.style.color = 'green';
			let postData = "getUserData=true&phone="+number.value+'&type='+type.value;
			let xhr = new XMLHttpRequest;
				xhr.open('POST', 'funcs/checkUser.php', true);
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