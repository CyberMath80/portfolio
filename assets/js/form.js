document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let data = new FormData(this);
    let xhr = createInstance();

    xhr.onreadystatechange = function() {
        console.log(this);
        if(this.readyState === 4 && this.status === 200) {
            console.log(this.response);
        } else if(this.readyState === 4) {
            console.log('Error !');
        }
    };

    xhr.open('POST', '/contact.php', true);
    xhr.responseType = 'json';
    //xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
    return false;
});

function createInstance() {
    let req = null;
    if(window.XMLHttpRequest)
        req = new XMLHttpRequest();

    else if(window.ActiveXObject) {
    try {
        req = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
        try {
            req = new ActiveXObject("Microsoft.XMLHTTP");
        } catch(e) {
            alert("XHR not created");
            }
        }
    }
    return req;
}