
	
	let loanToken = document.getElementById('loanToken');
	let bizInfo = document.getElementById('personInfoBtn');
	let bizAddress = document.getElementById('addressBtn');
	let bizSubmit = document.getElementById('bizSubmit');

	bizInfo.addEventListener('click', function(){
		let name = document.getElementById('name');
		let phone = document.getElementById('phone');
		let nin = document.getElementById('nin');
		let biztype = document.getElementById('biztype');
		let bizDesc = document.getElementById('bizDesc');
		let checks = document.querySelectorAll('.binf');
		let msg = document.getElementById('infoMsg');

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
			let postData = "personInfo="+loanToken.value+"&name="+name.value+'&phone='+phone.value+'&nin='+nin.value+'&biztype='+biztype.value+'&bizDesc='+bizDesc.value;
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
		let msg = document.getElementById('addMsg');

		let checkCnt = 0;
		for(i = 0; i < checks.length; i++){
			if(checks[i].value == '' || checks[i].value == ' '){
				let curItr = checks[i];
				curItr.style.border = '1px solid red';
				msg.innerText = "Missing fields";
				msg.style.display = 'block';
				msg.style.background = '#fecefe';
				msg.style.color = '#990000';
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
			let postData = "loanAddress="+loanToken.value+"&building="+building.value+'&street='+street.value+'&town='+town.value+'&state='+state.value;
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

		let agree = document.getElementById('agree');
		let msg = document.getElementById('subMsg');
		if(agree.checked == false){
			agree.style.border = '1px solid red';
			msg.innerText = "Please check the box if you agree with the stateent";
			msg.style.display = 'block';
			msg.style.background = '#fecefe';
			msg.style.color = '#990000';
			setTimeout(() => {
				agree.style.border = 'none';
				msg.style.display = 'none';
			}, 3000);
		} else {
			msg.style.display = 'block';
			msg.style.background = '#cefece';
			msg.style.color = 'green';
			msg.innerHTML = "Submitting  <i class='fa fa-spinner fa-spin'></i>";
			let postData = "loanSubmit="+loanToken.value;
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
								window.location = '?vendor&tkn='+loanToken.value
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
