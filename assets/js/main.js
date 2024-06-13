import Glide from '@glidejs/glide'

const initGlide = (el, startAt) => {
  new Glide(el, {
    type:"carousel",
    perView: 2,
    startAt: startAt ?? 1,
    focusAt: 'center',
    breakpoints: {
      1024: {
        perView: 1
      }
    }
  }).mount()
};


const initMobileNav = () => {
  const navM = document.querySelector(".lfl-js-nav-mobile");
  const navMOpen = navM.getElementsByTagName("button")[0];
  const navMOverlay = navM.querySelector(".lfl-js-nav-mobile__overlay");
  const navMClose = navMOverlay.getElementsByTagName("button")[0];

  navMOpen.addEventListener("click", () => {
    navMOverlay.classList.add("is-open");
    document.body.style.overflow = "hidden"; 
    navMOpen.setAttribute("aria-expanded", "true")
  })
  
  navMClose.addEventListener("click", () => {
    navMOverlay.classList.remove("is-open");
    document.body.style.overflow = "visible"; 
    navMOpen.setAttribute("aria-expanded", "false")
  })
}

// Function to handle link clicks
function handleLinkClick(event) {
  if (event.target.tagName === 'A' && event.target.hash) {
      // Check if the link points to a different page
      const href = event.target.getAttribute('href');
      if (href && href.includes('#')) {
          event.preventDefault();

          // Store the hash in sessionStorage
          sessionStorage.setItem('targetHash', event.target.hash);

          // Navigate to the target page
          window.location.href = href.split('#')[0];
      }
  }
}

// Function to handle hash change
function handleHashChange(hash) {
  try {
      if (hash && hash !== "#" && hash !== "") {
          // console.log("Hashchange - " + hash);

          // Jump to section with id of hash
          let target = document.querySelector(hash);
          if (target) {
              let offset = 80;
              scrollTo(target, offset);
          }
      }
  } catch (e) {
      console.error('Could not handle hash change: ' + hash);
  }
}

// Function to smoothly scroll to an element
function scrollTo(element, offset = 0, duration = 800) {
  // console.log('scrolling:');
  // console.log(element != null);

  if (element) {
    let targetPosition = element.getBoundingClientRect().top + window.pageYOffset - offset;
    window.scrollTo({
      top: targetPosition,
      behavior: 'smooth'
    });
  }
}

document.addEventListener("DOMContentLoaded", (event) => {
  // Init glide carousel, if element is present
  const items = document.querySelectorAll('.lfl-hp-team-member__title');
  const glideEl = document.querySelector('.glide')
  let startAt = 0;
  Array.from(items).findIndex((el, i)=>{
    if(el.textContent.toLowerCase().indexOf("jade") >= 0){
      startAt = i;
    }
  })
  
  if(glideEl){
    initGlide(glideEl, startAt);
  }

  // Init mobile nav
  initMobileNav();
  document.body.addEventListener('click', handleLinkClick);


  const targetHash = sessionStorage.getItem('targetHash');
  if (targetHash) {
      sessionStorage.removeItem('targetHash'); // Clear the stored hash
      handleHashChange(targetHash); // Handle the stored hash
  }

});
