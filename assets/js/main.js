import Glide from '@glidejs/glide'
const g = new Glide('.glide', {
  perView: 2,
  focusAt: 'center',
  breakpoints: {
    1024: {
      perView: 1
    }
  }
}).mount()

console.log('Little Fish Lab')
