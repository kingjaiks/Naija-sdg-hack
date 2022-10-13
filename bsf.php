<?php

// basic functions for text, SEO and others
$dbDirect = mysqli_connect('localhost', 'root', '','ptoject_ten');
$gtPostDate = date("D j M, Y");

// Text Functions
function textFilter($textString){
	$text = mysqli_real_escape_string(mysqli_connect('localhost', 'root', '','ptoject_ten'), $textString);
	$doublequotes = str_replace('\"', '&200%', $text);
	$singlequotes = str_replace("\'", '&100%', $doublequotes);
	$linebreak = str_replace('\r\n', '&300%', $singlequotes);
	$commas = str_replace(',', '&304%', $linebreak);

	return $commas;
}

function shortTextDisplay($text){
	$doublequotes = str_replace('&200%', '"', $text);
	$singlequotes = str_replace('&100%', "'", $doublequotes);
	$linebreak = str_replace('&300%', '..', $singlequotes);
	$comma = str_replace('&304%', ',', $linebreak);

	return $comma;
}

function longTextDisplay($text){
	$doublequotes = str_replace('&200%', '"', $text);
	$singlequotes = str_replace('&100%', "'", $doublequotes);
	$linebreak = str_replace('&300%', '<br>', $singlequotes);
	$comma = str_replace('&304%', ',', $linebreak);

	return $comma;
}

function inFormDisplay($text){
	$doublequotes = str_replace('&200%', '"', $text);
	$singlequotes = str_replace('&100%', "'", $doublequotes);
	$linebreak = str_replace('&300%', "\r\n", $singlequotes);
	$comma = str_replace('&304%', ',', $linebreak);

	return $comma;
}


function sendResetMail($name, $email, $link){

	$mailto = $email;	
	$subject = 'Password Reset Link';
	$message = "<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>Password Reset Link</title>
</head>
<body>

	<h1 style='color:#ff0000; font-family:sans-serif; border-bottom: 1px solid #ccc; font-size: 24px; padding-bottom: 10px; margin: 0;'>Password Reset Link</h1>
	
	<p style='color: #444; font-family:sans-serif; line-height: 2em; margin: 0;'>Hello $name, we got a request from our website with regards your trying to <strong>RESET / CHANGE</strong> your password. This message is intended a notification to you about the <span style='color:#ff0000; font-style: italic;' >High-Priority</span> action to be taken against your account and also to be a <span style='color:#ff0000; font-style: italic;'>Two-Step-Verification</span> to make sure you actually want to go through with it.</p>

	<p style='color: #444; font-family:sans-serif; line-height: 2em; margin: 0;'>We believe this message got to you properly as expected, if you never started this process or you changed your mind about the reset then ignore this message but if otherwise, use the reset button which will direct you to a page where you can create your new password.</p>

	<a href='$link' style='color:#fff; background: #ff0000; padding: 5px 10px; font-family:sans-serif; text-decoration: none; border-radius:5px;'>Reset My Password</a>

	<p style='color: #444; font-family:sans-serif; line-height: 2em; margin: 0;'> <strong>Note:</strong> The reset links expires within 15mins from the moment the request was made.</p>

	<p style='background:#eee; padding: 10px; font-family:sans-serif; font-size: 12px; text-align:center;'>
		this message was sent to <strong>$email</strong> automatically from <strong><a href='https://Bigvibesmagazine.com' style='color:#ff0000; text-decoration: none;'>Bigvibesmagazine.com</a></strong> because a request was made to reset your account password.
		<br><br>
		<b> &copy; Bigvibes Magazine</b>
	</p>
</body>
</html>";

	$headers = "From: Bigvibes Magazine. <info@Bigvibesmagazine.com> \r\n";
	$headers .= "Reply-to: info@Bigvibesmagazine.com \r\n";
	$headers .= "Content-type:text/html \r\n";

	//echo $message;

	if (mail($mailto, $subject, $message, $headers)) {
		return 'sent';
	} else {
		return 'failed';
	}

}
