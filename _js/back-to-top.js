/** Bouton back to top **/

// Récuper le bouton
let mybutton = document.getElementById("myBtn");

// Lorsque l'utilisateur fait défiler vers le bas de 20px depuis le haut du document affiche le bouton
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// Lorsque l'utilisateur clique sur le bouton faire défiler jusqu'en haut du document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

// Lorsque l'utilisateur clique sur le bouton faire défiler jusqu'en haut du document avec un effet smooth
function topFunction() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}
