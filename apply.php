<?php 
	
	$sql = "SELECT * from vendors where biz_user = '$usr' ";
	if($getDbData->queryCount($sql) < 1){
		$sql = "INSERT into vendors(`biz_user`) values('$usr'); ";
		$getDbData->dbQuery($sql);
	}
	$vendor = $getDbData->single($sql);

?>

<h1 class="mainHeading">Loan Vendor Application</h1>
<p style="font-size: 12px;">Fill form to become a vendor. please note that for you to be verified, your bussiness must have been registered with CAC and you must have been in operation for at least one year in the said field and location of business.</p>

<?php 
	
	if($vendor['biz_status'] == 1){
		header("Location: ?vendor");
	}
	elseif($vendor['biz_status'] == 2){ ?>
		<p style="border: 1px solid green; background: #cefece; color: darkgreen; padding: 10px; line-height: 1.5em; font-size:12px; ">Your application is being reviewed, while this is done, make sure your details are correct and true as any false information detected could lead to request denials and possible account suspention.</p>
	<?php }

?>

<div class="fullDisplaySection">
	<h3>Business Information</h3>
	<p style="font-size: 12px; margin: 0; padding: 8px; background: #ffe; color: brown; font-weight:bold; text-align:center; display: none;" id="bizInfoMsg">error message </p>
	<form>
		<input class="halfWidthInput binf" type="text" value="<?php echo inFormDisplay($vendor['biz_name']); ?>" placeholder="Business Name" id="bizName">
		<input class="halfWidthInput binf" type="number" value="<?php echo inFormDisplay($vendor['biz_phone']); ?>" placeholder="Business Phone Number"  id="bizPhone">
		<input class="halfWidthInput binf" type="email" value="<?php echo inFormDisplay($vendor['biz_email']); ?>" placeholder="Business Email" id="bizEmail">
		<input class="halfWidthInput binf" type="text" value="<?php echo inFormDisplay($vendor['biz_reg']); ?>" placeholder="Business Registration Number"  id="bizReg">
		<textarea class="halfWidthInput binf" cols="50" rows="5" placeholder="Business Description" id="bisDesc" maxlength="300" style="width: 94%; font-family: sans-serif;"><?php echo inFormDisplay($vendor['biz_desc']); ?></textarea>	
		<div class="clr"></div>
		<button class="boxBtn" type="button" id="bizInfoBtn"><i class="fa fa-save"></i> Save Details</button>
	</form>
</div>

<div class="fullDisplaySection">
	<h3>Business Account</h3>
	<p style="font-size: 12px; margin: 0; padding: 8px; background: #ffe; color: brown; font-weight:bold; text-align:center; display: none;" id="bizAccMsg">error message </p>
	<form>
		<input class="halfWidthInput accimp" type="number" value="<?php echo inFormDisplay($vendor['biz_bvn']); ?>" placeholder="BVN"  id="bizBVN">
		<input class="halfWidthInput accimp" type="text" value="<?php echo inFormDisplay($vendor['biz_bank']); ?>" placeholder="Bank Name " id="bizBank">
		<input class="halfWidthInput accimp" type="number" value="<?php echo inFormDisplay($vendor['biz_acc_number']); ?>" placeholder="Account Number" id="bizAcc">
		<input class="halfWidthInput accimp" type="text" value="<?php echo inFormDisplay($vendor['biz_acc_name']); ?>" placeholder="Account Name" id="bizAccName">		
		<div class="clr"></div>
		<button class="boxBtn" type="button" id="bizAccountBtn"><i class="fa fa-save"></i> Save Details</button>
	</form>
</div>

<div class="fullDisplaySection">
	<h3>Business Address</h3>
	<p style="font-size: 12px; margin: 0; padding: 8px; background: #ffe; color: brown; font-weight:bold; text-align:center; display: none;" id="bizAddMsg">error message </p>
	<form>
		<input class="halfWidthInput adrimp" type="text" value="<?php echo inFormDisplay($vendor['biz_building']); ?>" placeholder="No." id="bizBuilding">		
		<input class="halfWidthInput adrimp" type="text" value="<?php echo inFormDisplay($vendor['biz_street']); ?>" placeholder="Street" id="bizStreet">
		<input class="halfWidthInput adrimp" type="text" value="<?php echo inFormDisplay($vendor['biz_town']); ?>" placeholder="Town" id="bizTown">
		<input class="halfWidthInput adrimp" type="text" value="<?php echo inFormDisplay($vendor['biz_state']); ?>" placeholder="State"  id="bizState">
		<div class="clr"></div>
		<button class="boxBtn" type="button" id="bizAddressBtn"><i class="fa fa-save"></i> Save Details</button>
	</form>
</div>

<div class="fullDisplaySection">
	<p style="font-size: 12px; margin: 0; padding: 8px; background: #ffe; color: brown; font-weight:bold; text-align:center; display: none;" id="bizSubMsg">error message </p>
	<form>
		<textarea class="halfWidthInput" cols="50" rows="3" placeholder="Business description" id="signAgree" maxlength="300" style="width: 94%; font-family: sans-serif; line-height: 2em; color: #444;" readonly>By submitting this application, I <?php echo shortTextDisplay($userInfo['user_fullname']); ?> on <?php echo date("D j M, Y"); ?> agree that I shall be accountable and/or held responsible for every loan i approve.</textarea>	
		<div class="clr"></div>
		<button class="boxBtn" id="bizSubmit" type="button"><i class="fa fa-check"></i> Submit</button>
	</form>
</div>



<script type="text/javascript">
	
	let bizInfo = document.getElementById('bizInfoBtn');
	let bizAccount = document.getElementById('bizAccountBtn');
	let bizAddress = document.getElementById('bizAddressBtn');
	let bizSubmit = document.getElementById('bizSubmit');


	bizInfo.addEventListener('click', function(){
		let name = document.getElementById('bizName');
		let phone = document.getElementById('bizPhone');
		let email = document.getElementById('bizEmail');
		let reg = document.getElementById('bizReg');
		let desc = document.getElementById('bisDesc');
		let checks = document.querySelectorAll('.binf');
		let msg = document.getElementById('bizInfoMsg');

		let checkCnt = 0;
		for(i = 0; i < checks.length; i++){
			if(checks[i].value == '' || checks[i].value == ' '){
				let curItr = checks[i];
				curItr.style.border = '1px solid red';
				msg.innerText = "Missing fields";
				msg.style.display = 'block';
				setTimeout(() => {
					curItr.style.border = 'none';
					msg.style.display = 'none';
				}, 3000);
			} else {
				checkCnt++;
			}
		}

		if(checkCnt == 5){
			msg.style.display = 'block';
			msg.style.background = '#cefece';
			msg.style.color = 'green';
			msg.innerHTML = "Saving <i class='fa fa-spinner fa-spin'></i>";
			let postData = "bizInfo=true&name="+name.value+'&phone='+phone.value+'&email='+email.value+'&reg='+reg.value+'&desc='+desc.value;
			let xhr = new XMLHttpRequest;
				xhr.open("POST", 'funcs/funcs.php', true);
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						let response = JSON.parse(xhr.responseText);
						if(response.status == 200){
							msg.innerText = response.msg;
							setTimeout(() => {
								msg.style.display = 'none';
							}, 3000);
						} else {
							msg.style.background = '#fecefe';
							msg.style.color = '#990000';
							msg.innerText = response.msg;
						}
					}
				}
				xhr.send(postData);
		}
	});

	bizAccount.addEventListener('click', function(){
		let bvn = document.getElementById('bizBVN');
		let bank = document.getElementById('bizBank');
		let acc = document.getElementById('bizAcc');
		let accName = document.getElementById('bizAccName');
		let checks = document.querySelectorAll('.accimp');
		let msg = document.getElementById('bizAccMsg');

		let checkCnt = 0;
		for(i = 0; i < checks.length; i++){
			if(checks[i].value == '' || checks[i].value == ' '){
				let curItr = checks[i];
				curItr.style.border = '1px solid red';
				msg.innerText = "Missing fields";
				msg.style.display = 'block';
				setTimeout(() => {
					curItr.style.border = 'none';
					msg.style.display = 'none';
				}, 3000);
			} else {
				checkCnt++;
			}
		}

		if(checkCnt == 4){
			msg.style.display = 'block';
			msg.style.background = '#cefece';
			msg.style.color = 'green';
			msg.innerHTML = "Saving <i class='fa fa-spinner fa-spin'></i>";
			let postData = "bizAccount=true&bvn="+bvn.value+'&bank='+bank.value+'&acc='+acc.value+'&accName='+accName.value;
			let xhr = new XMLHttpRequest;
				xhr.open("POST", 'funcs/funcs.php', true);
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						let response = JSON.parse(xhr.responseText);
						if(response.status == 200){
							msg.innerText = response.msg;
							setTimeout(() => {
								msg.style.display = 'none';
							}, 3000);
						} else {
							msg.style.background = '#fecefe';
							msg.style.color = '#990000';
							msg.innerText = response.msg;
						}
					}
				}
				xhr.send(postData);
		}
	});

	bizAddress.addEventListener('click', function(){let bvn = document.getElementById('bizBVN');
		let building = document.getElementById('bizBuilding');
		let street = document.getElementById('bizStreet');
		let town = document.getElementById('bizTown');
		let state = document.getElementById('bizState');
		let checks = document.querySelectorAll('.adrimp');
		let msg = document.getElementById('bizAddMsg');

		let checkCnt = 0;
		for(i = 0; i < checks.length; i++){
			if(checks[i].value == '' || checks[i].value == ' '){
				let curItr = checks[i];
				curItr.style.border = '1px solid red';
				msg.innerText = "Missing fields";
				msg.style.display = 'block';
				setTimeout(() => {
					curItr.style.border = 'none';
					msg.style.display = 'none';
				}, 3000);
			} else {
				checkCnt++;
			}
		}

		if(checkCnt == 4){
			msg.style.display = 'block';
			msg.style.background = '#cefece';
			msg.style.color = 'green';
			msg.innerHTML = "Saving <i class='fa fa-spinner fa-spin'></i>";
			let postData = "bizAddress=true&building="+building.value+'&street='+street.value+'&town='+town.value+'&state='+state.value;
			let xhr = new XMLHttpRequest;
				xhr.open("POST", 'funcs/funcs.php', true);
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						let response = JSON.parse(xhr.responseText);
						if(response.status == 200){
							msg.innerText = response.msg;
							setTimeout(() => {
								msg.style.display = 'none';
							}, 3000);
						} else {
							msg.style.background = '#fecefe';
							msg.style.color = '#990000';
							msg.innerText = response.msg;
						}
					}
				}
				xhr.send(postData);
		}});
	bizSubmit.addEventListener('click', function(){

		let agree = document.getElementById('signAgree');
		let msg = document.getElementById('bizSubMsg');
		if(agree.value == '' || agree.value == ' '){
			curItr.style.border = '1px solid red';
			msg.innerText = "Missing fields";
			msg.style.display = 'block';
			setTimeout(() => {
				curItr.style.border = 'none';
				msg.style.display = 'none';
			}, 3000);
		} else {
			msg.style.display = 'block';
			msg.style.background = '#cefece';
			msg.style.color = 'green';
			msg.innerHTML = "Submitting  <i class='fa fa-spinner fa-spin'></i>";
			let postData = "bizSubmit=true&agree="+agree.value;
			let xhr = new XMLHttpRequest;
				xhr.open("POST", 'funcs/funcs.php', true);
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						// console.log(xhr.responseText);
						let response = JSON.parse(xhr.responseText);
						if(response.status == 200){
							msg.innerHTML = response.msg+"<i class='fa fa-check'></i>";
							setTimeout(() => {
								msg.style.display = 'none';
							}, 5000);
						} else {
							msg.style.background = '#fecefe';
							msg.style.color = '#990000';
							msg.innerText = response.msg;
						}
					}
				}
				xhr.send(postData);

		}

	});


</script>

<div class="clr"></div>