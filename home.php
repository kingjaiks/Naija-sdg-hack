<h1 class="mainHeading">Home Page</h1>

<div class="fullDisplaySection">
	<h3>Loan Vendor</h3>
	<p style="font-size: 12px;">Become our loan vendor and make more money using your existing business. click on <b>Apply</b> to get started.</p>
	<a href="?apply=true" class="boxBtn" type="button">Apply</a>
</div>

<?php 
	
	$sql = "SELECT * from connects where con_user = '$usr' and con_status = 'Active' order by con_id desc; ";
	if($getDbData->queryCount($sql) < 1){
		$conData = $getDbData->single($sql); ?>
<div class="fullDisplaySection">
	<h3>Connect e-Wallet Wallet</h3>
	<p style="font-size: 12px;">Click on connect to <b>Connect</b> your e-Wallet Wallet or click on <b>Create</b> if you dont have an e-Wallet wallet.</p>
	<a href="?connetuser=true" class="boxBtn" type="button">Connect</a>
	<a href="?newuser=true" class="boxBtn" type="button">Create</a>
	<a href="?checkuser=true" class="boxBtn" type="button">Check Details</a>

</div>
	<?php } ?>


<div class="fullDisplaySection">
	<h3>Receive Funds</h3>
	<p style="font-size: 12px;">Receive Funds from other valid tokens.</p>
	<form>
		<p id="chkMsg" style="font-size: 12px; font-weight: bold;"></p>
		<input type="text" placeholder="Enter token" id="payToken">
		<input type="number" placeholder="Enter Amount" id="payAmt">
		<button class="boxBtn" id="chkBtn" type="button">Receive <i class="fa fa-arrow-right"></i></button>
	</form>
</div>

<div class="clr"></div>

<script type="text/javascript">
	document.getElementById('chkBtn').addEventListener('click', function(){
		let token = document.getElementById('payToken');
		let amt = document.getElementById('payAmt');
		let msg = document.getElementById('chkMsg');
		if(token.value == '' || token.value == ' '){
			msg.innerText = 'Please enter a valid Debit token';
			msg.style.color = '#ff0000';
			token.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				token.style.border = 'none';
			}, 3000);
		}
		else if(amt.value < 1){
			msg.innerText = 'Please enter a valid amount you want to recieve';
			msg.style.color = '#ff0000';
			amt.style.border = '#ff0000 solid 1px';
			setTimeout(() => {
				amt.style.border = 'none';
			}, 3000);
		} else {
			msg.innerText = 'Processing... please wait.';
			msg.style.color = 'green';
			let postData = "getFunds=true&token="+token.value+'&amt='+amt.value;
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