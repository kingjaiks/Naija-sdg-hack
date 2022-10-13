<h1 class="mainHeading">Payment</h1>
<!-- 
<div class="dualDisplaySection">
	<h3>Account Balance</h3>
	<p class="accAmount">₦0.00</p>
	<p style="font-size: 12px;">Your Token: <b>teNUsrIdToken006</b></p>
</div> -->
<div class="clr"></div>

<div class="fullDisplaySection">
	<h3>Payment Form</h3>
	<form>
		<p id="chkMsg" style="font-size: 12px; font-weight: bold;"></p>
		<input type="text" name="token" placeholder="Enter Credit Token" id="token">	
		<input type="number" name="amount" placeholder="Enter Amount" id="amount">	
		<button type="button" id="chkBtn">Make Payment</button>
	</form>
</div>


<script type="text/javascript">
	document.getElementById('chkBtn').addEventListener('click', function(){
		let token = document.getElementById('token');
		let amt = document.getElementById('amount');
		let msg = document.getElementById('chkMsg');
		if(token.value == '' || token.value == ' '){
			msg.innerText = 'Please enter a Credit token';
			msg.style.color = '#ff0000';
			token.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				token.style.border = 'none';
			}, 3000);
		}
		else if(amt.value < 1){
			msg.innerText = 'Please enter an amount to Transfer';
			msg.style.color = '#ff0000';
			amt.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				amt.style.border = 'none';
			}, 3000);
		} else {
			msg.innerText = 'Processing... please wait.';
			msg.style.color = 'green';
			let postData = "payFunds=true&token="+token.value+'&amt='+amt.value;
			let xhr = new XMLHttpRequest;
				xhr.open('POST', 'funcs/getFunds.php', true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						// console.log(xhr.responseText);
						let response = JSON.parse(xhr.responseText);
						if(response.status == 200){

						} else {
							msg.innerText = response.msg;
							msg.style.color = '#ff0000';
						}
					}

				}
				xhr.send(postData);
		}
	});

</script>