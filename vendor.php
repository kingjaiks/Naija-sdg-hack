<?php 
$sql  ;

if(isset($_GET['tkn'])){ 

	$token = textFilter($_GET['tkn']);
	$sql = "SELECT * from tokens where token_code = '$token'";
	if($getDbData->queryCount($sql) > 0){
		$tokenData = $getDbData->single($sql);
		if($tokenData['token_user'] != $usr){
	      if($tokenData['token_type'] == 'Loan'){
	        if($tokenData['token_status'] == '1'){ 
	        	$sql = "SELECT * from loans where loan_token = '$token' ";
	    //     	if($getDbData->queryCount($sql) <= 0){
	    //     		$sql = "INSERT INTO `loans`(`loan_token`) VALUES('$token')";
					// $getDbData->dbQuery($sql);
	    //     	}
	        	$loanData = $getDbData->single($sql);
	        	?>

<!-- Main Loan form  -->
<h1 class="mainHeading">Loan Application</h1>
<!-- <p style="font-size: 12px;">Please ensure you collect caorrect information.</p> -->

<?php 
	
	if($loanData['loan_status'] == 2 || $loanData['loan_status'] == 1 || $loanData['loan_status'] == 3){ ?>

		<?php 
			if($loanData['loan_status'] == 1){ ?>
		<p style="border: 1px solid green; background: #cefece; color: darkgreen; padding: 10px; line-height: 1.5em; font-size:12px; ">Loan Application Aproved.</p>
			<?php } 

			elseif($loanData['loan_status'] == 2){ ?>
		<p style="border: 1px solid brown; background: #ffe; color: brown; padding: 10px; line-height: 1.5em; font-size:12px; ">Loan Application submitted successfully please confirm loan status.</p>
		<button class="boxBtn" type="button" id="aproveLoan"><i class="fa fa-check"></i> Aprove Loan</button>
		<button class="boxBtn" type="button" id="declineLoan"><i class="fa fa-times"></i> Decline Loan</button>

			<?php } 
			elseif($loanData['loan_status'] == 3){ ?>
		<p style="border: 1px solid #990000; background: #fecefe; color: #990000; padding: 10px; line-height: 1.5em; font-size:12px; ">Loan Application Declined.</p>
			<?php }
		?>

<div class="fullDisplaySection">
	<h3>Personal Information</h3>
	<p style="font-size: 12px; margin: 0; padding: 8px; background: #ffe; color: brown; font-weight:bold; text-align:center; display: none;" id="infoMsg">error message </p>
	<form>
		<input class="halfWidthInput binf" type="text" value="<?php echo  inFormDisplay($loanData['loan_name']); ?>" placeholder="Name" id="name" readonly>
		<input class="halfWidthInput binf" type="number" value="<?php echo inFormDisplay( $loanData['loan_phone']); ?>" placeholder="Phone Number"  id="phone" readonly>
		<input class="halfWidthInput binf" type="text" value="<?php echo  inFormDisplay($loanData['loan_nin']); ?>" placeholder="NIN" id="nin" readonly>
		<input class="halfWidthInput binf" type="text" maxlength="150" value="<?php echo  inFormDisplay($loanData['loan_biz']); ?>" placeholder="Type of Business"  id="biztype" readonly>
		<textarea class="halfWidthInput binf" cols="50" rows="5" placeholder="Business Description" id="bizDesc" maxlength="300" style="width: 94%; font-family: sans-serif;" readonly><?php echo  inFormDisplay($loanData['loan_desc']); ?></textarea>	
		<div class="clr"></div>
	</form>
</div>

<div class="fullDisplaySection">
	<h3>Business Address</h3>
	<form>
		<input class="halfWidthInput adrimp" value="<?php echo  inFormDisplay($loanData['loan_building']); ?>" type="text" placeholder="No." id="bizBuilding" readonly>		
		<input class="halfWidthInput adrimp" value="<?php echo  inFormDisplay($loanData['loan_street']); ?>" type="text" placeholder="Street" id="bizStreet" readonly>
		<input class="halfWidthInput adrimp" value="<?php echo  inFormDisplay($loanData['loan_town']); ?>" type="text" placeholder="Town" id="bizTown" readonly>
		<input class="halfWidthInput adrimp" value="<?php echo  inFormDisplay($loanData['loan_state']); ?>" type="text" placeholder="State"  id="bizState" readonly>
		<div class="clr"></div>
	</form>
</div>

<div class="fullDisplaySection">
	<form>
		<input type="text" placeholder="Enter Loan Token" value="<?php echo $loanData['loan_token']; ?>" id="loanToken" readonly>
		<p style="font-size: 12px; color: #444;">
			<?php echo shortTextDisplay($loanData['loan_agree']); ?>
		</p>
		<div class="clr"></div>
	</form>
</div>


<?php 
	if($loanData['loan_status'] == 2){ ?>


<script type="text/javascript">

let aproveLoan = document.getElementById('aproveLoan');
let declineLoan = document.getElementById('declineLoan');
let token = document.getElementById('loanToken');

aproveLoan.addEventListener('click', function(){
	updateStatus(this, 1);
});
declineLoan.addEventListener('click', function(){
	updateStatus(this, 3);
});

function updateStatus(btn, status){
	btn.innerHTML = "<i class='fa fa-spinner fa-spin'></i>";
	let postData = 'updateLoan='+token.value+'&status='+status;
	let xhr = new XMLHttpRequest;
		xhr.open("POST", 'funcs/funcs.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4 && xhr.status == 200){
				let response = JSON.parse(xhr.responseText);
				if(response.status == 200){
					window.location = "?vendor&tkn="+token.value;
				} else {

				}
			}
		}
		xhr.send(postData);
}
	
</script>



	<?php }

?>


<?php } else { ?>

<!-- Loan application form -->
<div class="fullDisplaySection">
	<h3>Personal Information</h3>
	<p style="font-size: 12px; margin: 0; padding: 8px; background: #ffe; color: brown; font-weight:bold; text-align:center; display: none;" id="infoMsg">error message </p>
	<form>
		<input class="halfWidthInput binf" type="text" value="<?php echo  inFormDisplay($loanData['loan_name']); ?>" placeholder="Name" id="name">
		<input class="halfWidthInput binf" type="number" value="<?php echo inFormDisplay( $loanData['loan_phone']); ?>" placeholder="Phone Number"  id="phone">
		<input class="halfWidthInput binf" type="text" value="<?php echo  inFormDisplay($loanData['loan_nin']); ?>" placeholder="NIN" id="nin">
		<input class="halfWidthInput binf" type="text" maxlength="150" value="<?php echo  inFormDisplay($loanData['loan_biz']); ?>" placeholder="Type of Business"  id="biztype">
		<textarea class="halfWidthInput binf" cols="50" rows="5" placeholder="Business Description" id="bizDesc" maxlength="300" style="width: 94%; font-family: sans-serif;"><?php echo  inFormDisplay($loanData['loan_desc']); ?></textarea>	
		<div class="clr"></div>
		<button class="boxBtn" type="button" id="personInfoBtn"><i class="fa fa-save"></i> Save Details</button>
	</form>
</div>

<div class="fullDisplaySection">
	<h3>Business Address</h3>
	<p style="font-size: 12px; margin: 0; padding: 8px; background: #ffe; color: brown; font-weight:bold; text-align:center; display: none;" id="addMsg">error message </p>
	<form>
		<input class="halfWidthInput adrimp" value="<?php echo  inFormDisplay($loanData['loan_building']); ?>" type="text" placeholder="No." id="bizBuilding">		
		<input class="halfWidthInput adrimp" value="<?php echo  inFormDisplay($loanData['loan_street']); ?>" type="text" placeholder="Street" id="bizStreet">
		<input class="halfWidthInput adrimp" value="<?php echo  inFormDisplay($loanData['loan_town']); ?>" type="text" placeholder="Town" id="bizTown">
		<input class="halfWidthInput adrimp" value="<?php echo  inFormDisplay($loanData['loan_state']); ?>" type="text" placeholder="State"  id="bizState">
		<div class="clr"></div>
		<button class="boxBtn" type="button" id="addressBtn"><i class="fa fa-save"></i> Save Details</button>
	</form>
</div>

<div class="fullDisplaySection">
	<p style="font-size: 12px; margin: 0; padding: 8px; background: #ffe; color: brown; font-weight:bold; text-align:center; display: none;" id="subMsg">error message </p>
	<form>
		<input type="text" placeholder="Enter Loan Token" value="<?php echo $loanData['loan_token']; ?>" id="loanToken" readonly>
		<p style="font-size: 12px; color: #444;">
			<input type="checkbox" id="agree" value="Agree" required style="width: initial;"> By submitting, I <b><em><?php echo shortTextDisplay($userInfo['user_fullname']); ?></em></b> agree that i will repay this loan if it goes wrong.
		</p>
		<div class="clr"></div>
		<button class="boxBtn" type="button" id="bizSubmit"><i class="fa fa-check"></i> Submit</button>
	</form>
</div>


<script type="text/javascript" src="js/loanpage.js"></script>
	<?php }

	        } else { ?>
				<p style="margin: 10px; font-size: 30px; color: #ddd; line-height:2em;">
				<i class="fa fa-times" style="font-size:70px;"></i><br>
					BLOCKED / DEACTIVATED: Token has been deactivated.
				</p>
			<?php }
	      } else { ?>
			<p style="margin: 10px; font-size: 30px; color: #ddd; line-height:2em;">
			<i class="fa fa-times" style="font-size:70px;"></i><br>
				INVALID TOKEN: This token is not a valid loan token.
			</p>
		<?php }
	    } else { ?>
		<p style="margin: 10px; font-size: 30px; color: #ddd; line-height:2em;">
		<i class="fa fa-times" style="font-size:70px;"></i><br>
			SELF GENERATED TOKEN: You can't utilize a token you generated.
		</p>
	<?php }

	} else { ?>
	<p style="margin: 10px; font-size: 30px; color: #ddd; line-height:2em;">
	<i class="fa fa-times" style="font-size:70px;"></i><br>
		Requested token not found, ensure you entered it correctly.
	</p>
	<?php }

} else { ?>

<h1 class="mainHeading">Loans</h1>
<p style="font-size: 12px;">Display of all loans you have aproved</p>

<div class="fullDisplaySection">
	<h3>New Loan</h3>
	<form>
		<input type="text" placeholder="Enter Loan Token" id="loanToken">
		<button class="boxBtn" type="button" id="vendToken"><i class="fa fa-check"></i> Proceed</button>
	</form>
</div>

<div id="tokenWraper"></div>

<script type="text/javascript">
	document.getElementById('vendToken').addEventListener('click', function(){
		let token = document.getElementById('loanToken');
		if(token.value == '' || token.value == ' '){
			token.style.border = '1px solid red';
			setTimeout(() => {
				token.style.border = 'none';
			}, 3000);
		} else {
			window.location = '?vendor&tkn='+token.value;
		}
	});

	
	function getTokens(){
		let xhr = new XMLHttpRequest;
			xhr.open('GET', 'funcs/funcs.php', true);
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
					document.getElementById('tokenWraper').innerHTML = xhr.responseText;
				}
			}
			xhr.send();
	}

	getTokens();

</script>


<?php }

?>




<div class="clr"></div>