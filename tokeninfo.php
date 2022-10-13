<?php 
	
	if(isset($_GET['tokeninfo'])){
		$token = $_GET['token'];
		$sql = "SELECT * from tokens where token_code = '$token' ";
		if($getDbData->queryCount($sql) > 0){
			$tokenData = $getDbData->single($sql); 
			if($tokenData['token_bal'] <= 0){
				$sql = "UPDATE tokens set token_status = 2 where token_code = '$token'; ";
				$getDbData->dbQuery($sql);
			} ?>

<div class="fullDisplaySection">
	<h3><?php echo shortTextDisplay($tokenData['token_title']); ?></h3>
	<h1 class="mainHeading"><?php echo $tokenData['token_code']; ?>
		<?php 
			if($tokenData['token_status'] == 0){ ?>
		<span class="status" id="tokenStatus" style="border-radius: 5px; background: #fecefe; color: #990000; font-size: 12px; padding: 7px 10px;">Disabled</span>
			<?php } 
			elseif($tokenData['token_status'] == 1){ ?>
		<span class="status" id="tokenStatus" style="border-radius: 5px; background: #cefece; color: green; font-size: 12px; padding: 7px 10px;">Active</span>
			<?php } else { ?>
		<span class="status" id="tokenStatus" style="border-radius: 5px; background: #ffb; color: #990000; font-size: 12px; padding: 7px 10px;">Exhusted</span>
			<?php }
		?>
	</h1>
	<p style="font-size: 14px; font-style: italic; margin: 0; padding: 5px;">
		<b>Limit</b>: ₦<?php echo $tokenData['token_amount']; ?> | <b>Balance</b>: ₦<?php echo $tokenData['token_bal']; ?>
	</p>
	<?php 
		if($tokenData['token_type'] != 'Loan'){ ?>

	<button id="disableBtn" class="boxBtn" type="button">Disable</button>
	<button id="activateBtn" class="boxBtn" type="button">Activate</button>
		
		<?php } else {
		 $sql = "SELECT * from loans where loan_token = '$token' order by loan_id desc; ";
		$loan = $getDbData->single($sql); ?>
		<div class="fullDisplaySection" style="position:relative; padding: 5px; border-left:<?php if($loan['loan_payment'] == '0'){ echo '5px solid red'; } else { echo '5px solid green';} ?>">
		    <a style="margin: 0; font-size:20px; color: green; font-size: 16px; text-decoration:none; "> <?php echo shortTextDisplay($loan['loan_name']); ?> | <small style="color: #333; font-size: 12px;">
		      <?php echo shortTextDisplay($loan['loan_phone']); ?>
		    </small> </a>
		    <p style="font-size: 12px; font-style: italic; margin: 0;">
		      Loan Aaount: <?php echo $tokenData['token_amount']; ?>
		      Date:<?php echo $loan['loan_date']; ?>
		        
		    </p>
		    <?php 
		      if($loan['loan_payment'] == 0){ ?>
		    <div class="status" style="position: absolute; right: 10px; top: 5px; border-radius: 5px; background: #fecefe; color: #990000; font-size: 12px; padding: 7px 10px;">Not Paid</div>
		      <?php } 
		      elseif($loan['loan_payment'] == 1){ ?>
		    <div class="status" style="position: absolute; right: 10px; top: 5px; border-radius: 5px; background: #cefece; color: green; font-size: 12px; padding: 7px 10px;">Paid</div>
		      <?php } else { ?>
		    <div class="status" style="position: absolute; right: 10px; top: 5px; border-radius: 5px; background: #ffb; color: #990000; font-size: 12px; padding: 7px 10px;">Pending</div>
		      <?php }
		    ?>
		  </div>
	<?php } ?>
</div>



<div id="tokenWraper"></div>
<br><br><br>

<script type="text/javascript">

	let disableBtn = document.getElementById('disableBtn');
	let activateBtn = document.getElementById('activateBtn');

	disableBtn.addEventListener('click', function(){
		disableBtn.innerHTML = "Processing <i class='fa fa-spinner fa-spin'></i> ";
		let postData = "disableToken=true&token=<?php echo $tokenData['token_code']; ?>";
		let xhr = new XMLHttpRequest;
			xhr.open('POST', 'funcs/getFunds.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
					let response = JSON.parse(xhr.responseText);
					if(response.status == 200){
						document.getElementById('tokenStatus').innerText = 'Disabled';
						document.getElementById('tokenStatus').style.background = '#fecefe';
						document.getElementById('tokenStatus').style.color = '#990000';

						disableBtn.innerHTML = "Disabled <i class='fa fa-check'></i> ";
						setTimeout(() => {
							disableBtn.innerText = "Disable";
						}, 3000);

					} else {
						disableBtn.innerHTML = "Failed <i class='fa fa-spinner fa-spin'></i> ";
						setTimeout(() => {
							disableBtn.innerHTML = "Disable";
						}, 3000);
					}
				}
			}
			xhr.send(postData);
	});

	activateBtn.addEventListener('click', function(){
		activateBtn.innerHTML = "Processing <i class='fa fa-spinner fa-spin'></i> ";
		let postData = "enableToken=true&token=<?php echo $tokenData['token_code']; ?>";
		let xhr = new XMLHttpRequest;
			xhr.open('POST', 'funcs/getFunds.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
					let response = JSON.parse(xhr.responseText);
					if(response.status == 200){
						document.getElementById('tokenStatus').innerText = 'Active';
						document.getElementById('tokenStatus').style.background = '#cefece';
						document.getElementById('tokenStatus').style.color = 'green';

						activateBtn.innerHTML = "Activated <i class='fa fa-check'></i> ";
						setTimeout(() => {
							activateBtn.innerText = "Activate";
						}, 3000);

					} else {
						activateBtn.innerHTML = "Failed <i class='fa fa-spinner fa-spin'></i> ";
						setTimeout(() => {
							activateBtn.innerHTML = "Activate";
						}, 3000);
					}
				}
			}
			xhr.send(postData);
	});
	
	function getTokens(token){
		let postData = 'getTrans=true&token='+token;
		let xhr = new XMLHttpRequest;
			xhr.open('POST', 'funcs/getFunds.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
					// console.log(token);
					document.getElementById('tokenWraper').innerHTML = xhr.responseText;
				}
			}
			xhr.send(postData);
	}
	getTokens("<?php echo $tokenData['token_code']; ?>");

</script>

		<?php } else { ?>

			<p style="margin: 10px; font-size: 30px; color: #ddd; line-height:2em;">
			<i class="fa fa-times" style="font-size:70px;"></i><br>
				Requested token not found, please check the link followed.
			</p>

		<?php }

	} else { ?>

	<p style="margin: 10px; font-size: 30px; color: #ddd; line-height:2em;">
	<i class="fa fa-times" style="font-size:70px;"></i><br>
		Invalid URL, please ensure the link followed is correct.
	</p>

	<?php }

?>
