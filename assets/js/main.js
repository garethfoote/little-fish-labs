import Glide from '@glidejs/glide'

const initGlide = (el) => {
  new Glide(el, {
    perView: 2,
    focusAt: 'center',
    breakpoints: {
      1024: {
        perView: 1
      }
    }
  }).mount()
};

document.addEventListener("DOMContentLoaded", (event) => {
  // Init glide carousel, if element is present
  const glideEl = document.querySelector('.glide')
  if(glideEl){
    initGlide(glideEl);
  }

  // Init mobile nav
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

});
