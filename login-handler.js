
// getting the click btn command
document.getElementById('loginBtn').addEventListener('click', function (){

let userId = document.getElementById('userId');
let userPass = document.getElementById('pwd');
let msg = document.getElementById('logMsg');

// checking for user identifyer entry
if(userId.value == '' || userId.value == ' '){
	msg.innerText = 'Enter a valid User Identifyer!';
	userId.style.border = '2px solid #ff0000';
	setTimeout(() => {
		userId.style.border = '2px solid #ccc';
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

// all set ============= making server request qith AJAX
else {

	let formData = userId.value + '|||' + userPass.value;

	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'funcs/loginaider.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function (){
		if(xhr.readyState < 4){
			msg.innerText = 'Verifying Credentials...';
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
	xhr.send('login=' + formData);

}

//console.log(userId);

});