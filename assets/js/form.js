const FORM       = document.getElementById('contact-form');

FORM.addEventListener('submit', function(e) {
	e.preventDefault();

	let data = new FormData(this);

	let xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.response);
			let res = this.response;
			if (res.success) {
				console.log('Success !');
			} else {
				console.log(res.msg);
			}
		} else if (this.readyState == 4) {
			console.log('Une erreur est survenue...');
		}
	};

	xhr.open('POST', '../../contact.php', true);
	xhr.responseType = 'json';
	// xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);

	return false;
});