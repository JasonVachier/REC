let lastScrollTop = 0;
const nav = document.querySelector('.nav-header');

window.addEventListener('scroll', function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop) {
        // Défilement vers le bas
        nav.style.transform = 'translateY(-100%)'; // Masquer la barre de navigation
    } else {
        // Défilement vers le haut
        nav.style.transform = 'translateY(0)'; // Afficher la barre de navigation
    }
    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Pour éviter les valeurs négatives
});


document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const navHeader = document.querySelector('.nav-header');

    if (menuToggle) {
        menuToggle.addEventListener('click', function () {
            navHeader.classList.toggle('open'); // Utilise la classe 'open' pour montrer/cacher le menu
        });
    } else {
        console.error('Le bouton .menu-toggle n\'a pas été trouvé');
    }
});