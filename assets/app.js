import './styles/app.css';
import 'bootstrap';

/**
 * 1. LOGIQUE DE LA NAVBAR DYNAMIQUE
 * On cible le 'header' pour correspondre à ton code HTML actuel.
 */
const handleNavbarScroll = () => {
    const header = document.querySelector('header');
    const logo = header ? header.querySelector('img') : null;

    if (header) {
        if (window.scrollY > 50) {
            // Réduction et ombre
            header.style.padding = "0px";
            header.classList.add('shadow-sm');
            if (logo) {
                logo.style.height = "80px";
                logo.style.width = "auto";
            }
            header.style.transition = "all 0.4s ease";
            if (logo) logo.style.transition = "all 0.4s ease";
        } else {
            // Retour à l'état initial
            header.style.padding = "10px 0px";
            header.classList.remove('shadow-sm');
            if (logo) logo.style.height = "130px";
        }
    }
};

/**
 * 2. FONCTION D'ANIMATION AU SCROLL (REVEAL)
 * Fait apparaître les éléments avec la classe .reveal
 */
const handleReveal = () => {
    const reveals = document.querySelectorAll('.reveal');
    reveals.forEach(el => {
        const windowHeight = window.innerHeight;
        const revealTop = el.getBoundingClientRect().top;
        if (revealTop < windowHeight - 120) {
            el.classList.add('active');
        }
        else {
            el.classList.remove('active');
        }
    });
};

const handleScrollSpy = () => {
    const sections = document.querySelectorAll('section[id]'); // On cible les sections avec un ID
    const scrollY = window.scrollY;

    sections.forEach(current => {
        const sectionHeight = current.offsetHeight;
        const sectionTop = current.offsetTop - 150; // On ajuste pour déclencher un peu avant
        const sectionId = current.getAttribute('id');
        
        // On cible le lien dans la navbar qui a le href correspondant à l'id de la section
        const navLink = document.querySelector(`.nav-link[href*="${sectionId}"]`);

        if (navLink) {
            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                navLink.classList.add('active');
            } else {
                navLink.classList.remove('active');
            }
        }
    });
};


// Intègre-le dans ton initialisation globale existante
document.addEventListener('DOMContentLoaded', () => {
    handleScrollSpy();
    window.addEventListener('scroll', () => {
        handleScrollSpy();
        // Garde tes autres fonctions ici (handleNavbarScroll, handleReveal...)
    });
});

/**
 * 3. INITIALISATION GLOBALE
 */
document.addEventListener('DOMContentLoaded', () => {
    // Exécution immédiate au chargement
    handleNavbarScroll();
    handleReveal();

    // Écouteur unique sur le défilement
    window.addEventListener('scroll', () => {
        handleNavbarScroll();
        handleReveal();
    });
});


//pour la galerie de a propos 
document.addEventListener('DOMContentLoaded', function() {
    // 1. On récupère le Modal et le Carrousel
    const myModalEl = document.getElementById('aproposLightbox');
    const myCarouselEl = document.getElementById('carouselApropos');

    if (myModalEl && myCarouselEl) {
        // Initialisation manuelle du carrousel Bootstrap
        const carouselInstance = new bootstrap.Carousel(myCarouselEl, {
            interval: false, // Empêche le défilement automatique
            ride: false
        });

        // 2. Gestion du clic sur les miniatures
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.addEventListener('click', function() {
                const slideTo = parseInt(this.getAttribute('data-bs-slide-to'));
                // On force le carrousel à aller à l'image cliquée
                carouselInstance.to(slideTo);
            });
        });
    }
});