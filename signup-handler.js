
// getting the click btn command
document.getElementById('signupBtn').addEventListener('click', function (){

let userName = document.getElementById('userName');
let userEmail = document.getElementById('userEmail');
let userPhone = document.getElementById('userPhone');
let userPass = document.getElementById('pwd');
let userRePass = document.getElementById('repwd');
let msg = document.getElementById('logMsg');

// checking for user identifyer entry
if(userName.value == '' || userName.value == ' '){
	msg.innerText = 'Please enter your display name';
	userName.style.border = '2px solid #ff0000';
	setTimeout(() => {
		userName.style.border = '2px solid #ccc';
	}, 3000);
}

else if(userEmail.value == '' || userEmail.value == ' '){
	msg.innerText = 'Please enter your active email address';
	userEmail.style.border = '2px solid #ff0000';
	setTimeout(() => {
		userEmail.style.border = '2px solid #ccc';
	}, 3000);
}

else if(userPhone.value == '' || userPhone.value == ' '){
	msg.innerText = 'Please enter your phone number';
	userPhone.style.border = '2px solid #ff0000';
	setTimeout(() => {
		userPhone.style.border = '2px solid #ccc';
	}, 3000);
}

// checking for password entry
else if(userPass.value == '' || userPass.value == ' '){
	msg.innerText = 'Enter your Password';
	userPass.style.border = '2px solid #ff0000';
	setTimeout(() => {
		userPass.style.border = '2px solid #ccc';
	}, 3000);
}


else if(userRePass.value == '' || userRePass.value == ' '){
	msg.innerText = 'Please repeat your password';
	userRePass.style.border = '2px solid #ff0000';
	setTimeout(() => {
		userRePass.style.border = '2px solid #ccc';
	}, 3000);
}
// all set ============= making server request qith AJAX
else {

	let formData = "signup=true&name=" + userName.value + "&email=" + userEmail.value + "&phone=" + userPhone.value + "&pwd=" + userPass.value + "&repwd=" + userRePass.value ;

	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'funcs/loginaider.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function (){
		if(xhr.readyState < 4){
			msg.innerText = 'Processing Request...';
		}

		else if(xhr.readyState == 4 && xhr.status == 200){
			let response = xhr.responseText.split(' - ');
			console.log(response);
			if(response[0] == "\r\n200"){
				window.location = 'account.php';
			} 
			else{
				msg.innerText = response[1];
			}
		}
	};
	xhr.send(formData);

}

//console.log(userId);

});