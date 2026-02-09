/* ======================================================
   MENU MOBILE
===================================================== */
const menuToggle = document.querySelector(".menu-toggle");
const navLinks = document.querySelector(".nav-links");
const navItems = document.querySelectorAll(".nav-links a");

menuToggle.addEventListener("click", () => {
    menuToggle.classList.toggle("open");
    navLinks.classList.toggle("active");
    document.body.classList.toggle("menu-open");
});

navItems.forEach(link => {
    link.addEventListener("click", () => {
        menuToggle.classList.remove("open");
        navLinks.classList.remove("active");
        document.body.classList.remove("menu-open");
    });
});


/* ======================================================
   PROCEDURE CARDS (ACCORDION + SCROLL REVEAL)
===================================================== */
const procedureCards = document.querySelectorAll(".procedure-card");

// Observer para Scroll Reveal
const revealObserver = new IntersectionObserver(
    entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
                revealObserver.unobserve(entry.target);
            }
        });
    },
    {
        threshold: 0.15,
        rootMargin: "0px 0px -60px 0px"
    }
);

procedureCards.forEach(card => {
    // Scroll Reveal
    revealObserver.observe(card);

    // Accordion (apenas para <details>)
    if ("open" in card) {
        card.addEventListener("toggle", () => {
            if (card.open) {
                procedureCards.forEach(other => {
                    if (other !== card) other.removeAttribute("open");
                });
            }
        });
    }
});

const btn = document.querySelector('.load-more');
const cards = document.querySelectorAll('.procedure-card');

let expanded = false; // estado do "Veja Mais / Menos"

// função que define quais cards aparecem inicialmente
function updateCards() {
    const width = window.innerWidth;

    // reset: remove hidden de todos
    cards.forEach(card => card.classList.remove('hidden'));

    if(!expanded) {
        if(width < 640) { // MOBILE: mostrar 4
            cards.forEach((card, i) => { if(i >= 4) card.classList.add('hidden'); });
        } else if(width >= 640 && width < 1024) { // TABLET: 2 colunas, mostrar 2 primeiras duplas (4 cards)
            cards.forEach((card, i) => { if(i >= 4) card.classList.add('hidden'); });
        } else { // DESKTOP: 3 colunas, mostrar 6 cards
            cards.forEach((card, i) => { if(i >= 6) card.classList.add('hidden'); });
        }
        btn.textContent = 'Veja Mais';
    } else {
        // expandido: mostra todos
        cards.forEach(card => card.classList.remove('hidden'));
        btn.textContent = 'Veja Menos';
    }
}

// inicial
updateCards();

// ao redimensionar
window.addEventListener('resize', () => {
    expanded = false; // reseta para estado inicial
    updateCards();
});

// clique no botão
btn.addEventListener('click', () => {
    expanded = !expanded; // alterna estado
    updateCards();
});

// =========================
// TROCA DE PESSOAS
// =========================
const people = [
  {
    name: 'Isabelle Araujo',
    photo: 'assets/images/isabelle.jpg',
    text: 'Lorem ipsum dolor sit amet consectetur.Lorem ipsum ddolor sit amet consecteturLorem ipsum dolor sit amet consectetur Vel sed viverra vitae pulvinar. Aliquet pellentesque metus a iaculis tortor. Ut ut quam ipsum aliquam ac nullam gravida. Mattis vitae pharetra a sed. Dolor sit morbi at varius est eget. Neque nec sed molestie nisl. Ullamcorper pharetra in massa montes risus. Hendrerit ultrices metus tempus est tempor consequat. Faucibus pellentesque fermentum accumsan quisque rhoncus elementum nullam nisi enim. Amet enim aliquam sapien iaculis diam tristique urna ut ornare. Rutrum adipiscing in et nisl a diam interdum justo curabitur'
  },
  {
    name: 'Raquel Araujo',
    photo: 'assets/images/raquel.png',
    text: 'Lorem ipsum dolor sit amet consectetur.Lorem ipsum ddolor sit amet consecteturLorem ipsum dolor sit amet consectetur Vel sed viverra vitae pulvinar. Aliquet pellentesque metus a iaculis tortor. Ut ut quam ipsum aliquam ac nullam gravida. Mattis vitae pharetra a sed. Dolor sit morbi at varius est eget. Neque nec sed molestie nisl. Ullamcorper pharetra in massa montes risus. Hendrerit ultrices metus tempus est tempor consequat. Faucibus pellentesque fermentum accumsan quisque rhoncus elementum nullam nisi enim. Amet enim aliquam sapien iaculis diam tristique urna ut ornare. Rutrum adipiscing in et nisl a diam interdum jus'  }
];

let currentIndex = 0;

const nameEl = document.querySelector('.about-text h3');
const textEl = document.querySelector('.about-text p');
const photoEl = document.querySelector('.about-photo');
const aboutText = document.querySelector('.about-text');

function fadeOut(element, callback) {
  element.style.opacity = 0;
  setTimeout(callback, 300);
}

function fadeIn(element) {
  element.style.opacity = 1;
}

function updatePerson() {
  const person = people[currentIndex];

  fadeOut(photoEl, () => {
    photoEl.src = person.photo;
    photoEl.alt = person.name;
    fadeIn(photoEl);
  });

  fadeOut(aboutText, () => {
    nameEl.textContent = person.name;
    textEl.textContent = person.text;
    fadeIn(aboutText);
  });
}

document.querySelector('.left-arrow').addEventListener('click', () => {
  currentIndex = (currentIndex - 1 + people.length) % people.length;
  updatePerson();
});

document.querySelector('.right-arrow').addEventListener('click', () => {
  currentIndex = (currentIndex + 1) % people.length;
  updatePerson();
});


const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
    }
  });
}, { threshold: 0.2 });

document.querySelectorAll('.fade-in, .slide-left, .slide-right')
  .forEach(el => observer.observe(el));


  