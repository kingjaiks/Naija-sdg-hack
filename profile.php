<h1> <i class="fa fa-info"></i> Profile Info</h1>

<!-- <div class="dualDisplaySection">
	<h3>Active User</h3>
	<p>
		<?php echo shortTextDisplay($userInfo['user_fullname']); ?> <br>
		<?php echo $userInfo['user_email']; ?> <br>
		<?php echo $userInfo['user_phone']; ?>
	</p>
</div> -->
<?php 
	
	$sql = "SELECT * from connects where con_user = '$usr' and con_status = 'Active' order by con_id desc; ";
	if($getDbData->queryCount($sql) > 0){
		$conData = $getDbData->single($sql); ?>
<div class="dualDisplaySection">
	<h3><i class="fa fa-wallet"></i> Connected Wallet</h3>
	<p>
		Name: <?php echo shortTextDisplay($userInfo['user_fullname']); ?> <br>
		Nuban: <?php echo $userInfo['user_email']; ?> <br>
		Alias: <?php echo $userInfo['user_phone']; ?>
	</p>
</div>
	<?php } else { ?>

<div class="dualDisplaySection">
	<h3><i class="fa fa-wallet"></i> Connected Wallet</h3>
	<p >You have not connect this account to your e-Wallet wallet, please click on Connect to link your wallet.</p>
</div>

<div class="dualDisplaySection">
	<h3>Connect e-Wallet Wallet</h3>
	<p style="font-size: 12px;">Click on connect to <b>Connect</b> your e-Wallet Wallet or click on <b>Create</b> if you dont have an e-Wallet wallet.</p>
	<a href="?connetuser=true" class="boxBtn" type="button">Connect</a>
	<a href="?newuser=true" class="boxBtn" type="button">Create</a>
	<a href="?checkuser=true" class="boxBtn" type="button">Check Details</a>

</div>


	<?php }

?>

<div class="clr"></div>

<div class="dualDisplay">
	<?php 
		if(isset($_GET['msg'])){ ?>
	<p style="margin:0; padding: 8px 10px; background: #cefece; color: green; text-align: center; box-sizing:border-box;"><?php echo $_GET['msg'] ?></p>
		<?php }
	?>
	<form action="funcs/form-process.php" method="POST">
		<input type="text" name="name" placeholder="Enter Name" value="<?php echo shortTextDisplay($userInfo['user_fullname']); ?>" class="mainInput" required>
		<input type="email" name="email" placeholder="Enter Email" value="<?php echo shortTextDisplay($userInfo['user_email']); ?>" class="mainInput" required>
		<input type="number" name="phone" placeholder="Enter Phone" value="<?php echo shortTextDisplay($userInfo['user_phone']); ?>" class="mainInput" required>
		<input type="text" name="state" placeholder="Enter State" value="<?php echo shortTextDisplay($userInfo['user_state']); ?>" class="mainInput" required>
		<input type="text" name="town" placeholder="Enter Town" value="<?php echo shortTextDisplay($userInfo['user_town']); ?>" class="mainInput" required>
		<input type="text" name="street" placeholder="Enter Street" value="<?php echo shortTextDisplay($userInfo['user_street']); ?>" class="mainInput" required>
		<input type="text" name="building" placeholder="Enter Building N0." value="<?php echo shortTextDisplay($userInfo['user_building']); ?>" class="mainInput" required>
		<button type="submit" name="updateUser"> <i class="fa fa-save"></i> Save Changes</button>
	</form>
</div>