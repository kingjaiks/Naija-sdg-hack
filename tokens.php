<h1 class="mainHeading">Tokens</h1>

<div class="fullDisplaySection">
	<h3>Generate Token</h3>
	<form>
		<p id="chkMsg" style="font-size: 12px; font-weight: bold;"></p>
		<input type="text" name="title" placeholder="Enter Title/Caption " id="title">	
		<input type="number" name="amount" placeholder="Allocate Amount" id="amount">	
		<select id="idType" >
			<option value="">:: Token Type ::</option>
			<option value="Debit">Debit Token</option>
			<option value="Credit">Credit Token</option>
		</select> <br>
		<button type="button" id="generateTokenBtn">Generate</button>
	</form>
</div>


<div id="tokenWraper"></div>


<script type="text/javascript">
	document.getElementById('generateTokenBtn').addEventListener('click', function(){
		let title = document.getElementById('title');
		let amount = document.getElementById('amount');
		let type = document.getElementById('idType');
		// let date = document.getElementById('date');
		// let merchant = document.getElementById('merchant');
		let msg = document.getElementById('chkMsg');
		if(title.value == '' || title.value == ' '){
			msg.innerText = 'Please enter token caption';
			msg.style.color = '#ff0000';
			title.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				title.style.border = 'none';
			}, 3000);
		}
		// else if(date.value == '' || date.value == ' '){
		// 	msg.innerText = 'Please set Token Expiration Date';
		// 	msg.style.color = '#ff0000';
		// 	date.style.border = '#ff0000 solid 1px';
		// 	setTimeout(() => {
		// 		date.style.border = 'none';
		// 	}, 3000);
		// }
		else if(amount.value <= 0){
			msg.innerText = 'Please enter token Amount';
			msg.style.color = '#ff0000';
			amount.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				amount.style.border = 'none';
			}, 3000);
		}
		else if(type.value == ''){
			msg.innerText = 'Please select token type;';
			msg.style.color = '#ff0000';
			type.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				type.style.border = 'none';
			}, 3000);
		}
		// else if(merchant.value == ''){
		// 	msg.innerText = 'Please select token utilizer;';
		// 	msg.style.color = '#ff0000';
		// 	merchant.style.border = '#ff0000 solid 1px';
		// 	setTimeout(() => {
		// 		merchant.style.border = 'none';
		// 	}, 3000);
		// } 
		else {
			msg.innerText = 'Processing Request...';
			msg.style.color = 'green';
			let postData = "generateToken=true&title="+title.value+"&amount="+amount.value+"&type="+type.value;
			let xhr = new XMLHttpRequest;
				xhr.open('POST', 'funcs/generate.php', true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						// console.log(xhr.responseText);
						let response = JSON.parse(xhr.responseText);
						if(response.status == 200){
							msg.innerText = 'Success: Token = '+ response.token;
							msg.style.color = 'green';
							getTokens();
							setTimeout(() => {
								window.location = '?tokeninfo=true&token='+response.token;
							}, 3000);
						} else {
							msg.innerText = response.msg;
							msg.style.color = '#ff0000';
						}
					}

				}
				xhr.send(postData);
		}
	});

	function getTokens(){
		let xhr = new XMLHttpRequest;
			xhr.open('GET', 'funcs/generate.php', true);
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
					document.getElementById('tokenWraper').innerHTML = xhr.responseText;
				}
			}
			xhr.send();
	}

	getTokens();

</script>