const BTN_SUBMIT = document.getElementById('btn-submit');

BTN_SUBMIT.addEventListener('click', () => {
    sendForm();
});

function sendForm()
{
    // Récupération des valeurs des champs de formulaire
    let post_id = document.getElementById('post_id').value;
    let name    = document.getElementById('name').value;
    let email   = document.getElementById('email').value;
    let subject = document.getElementById('subject').value;
    let message = document.getElementById('message').value;

    // Préparation de la querystring d'URL
    let params = '?post_id=' + encodeURIComponent(post_id);
    params += '&name=' + encodeURIComponent(name);
    params += '&email=' + encodeURIComponent(email);
    params += '&subject=' + encodeURIComponent(subject);
    params += '&message=' + encodeURIComponent(message);

// Récupération de l'objet XHR
let xhr = new XMLHttpRequest();

// On assigne une fonction qui, lorsque l'état de la requête change, va traiter le résultat
xhr.onreadystatechange = function() {
    // readyState 4 = requête terminée
    if (xhr.readyState == 4) {
        // status 200 = page requêtée trouvée
        if (xhr.status == 200)
            ajaxBox_setText(xhr.responseText);
        // Page non trouvée
        else
            ajaxBox_setText('Error...');
    }
};

// Passage des paramètres à l'URL puis éxecution de la requête
let url = 'https://cybermath.dev/forms/contact.php' + params;
xhr.open('GET', url, true);
xhr.send(null);
}

// Fonction de mise à jour du contenu de l'élement HTML #result
function ajaxBox_setText(pText) {
    let p = document.getElementById('result');
    p.appendChild(document.createTextNode(pText));
}