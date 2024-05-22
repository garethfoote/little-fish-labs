import Glide from '@glidejs/glide'

if(document.querySelector('.glide')){
  new Glide('.glide', {
    perView: 2,
    focusAt: 'center',
    breakpoints: {
      1280: {
        perView: 1
      }
    }
  }).mount()
}
console.log('Little Fish Lab')
