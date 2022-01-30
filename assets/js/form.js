const FORM = document.getElementById('contact-form');
const MYURL  = 'https://cybermath.dev/forms/contact.php';

FORM.addEventListener('submit',(event) => {
    event.preventDefault();

    let request = new XMLHttpRequest();
    //POST to any url
    request.open('POST', MYURL, false);

    let formData = new FormData(FORM);
    request.send(formData);
});