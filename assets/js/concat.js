const phone   = document.querySelectorAll('.data-p');
const email   = document.querySelectorAll('.data-e');

const current = document.querySelector('.year');
const year    = new Date();

for(let i = 0; i < phone.length; i++) {
    phone[i].innerHTML = '<a href="tel:+32477388045">+32 (0) 477 388 045</a>';
}

for(let i = 0; i < phone.length; i++) {
    email[i].innerHTML = '<a href="mailto:contact@cybermath.dev">contact@cybermath.dev</a>';
}

current.textContent = year.getFullYear();