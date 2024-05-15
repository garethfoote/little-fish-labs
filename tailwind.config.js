/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./views/**/*.twig"
  ],
  theme: {
    fontFamily: {
      sans: ['nimbus_sans_lregular']
    },
    screens: {
      'sm': '640px',
      'md': '768px',
      'lg': '1024px',
      'xl': '1280px',
      '2xl': '1536px',
    },
    fontSize: {
      xs: ['0.6875rem', '1.25rem'], // 13px
      sm: ['0.875rem', '1.25rem'], // 13px
      base: ['1rem', '1.5rem'], // 16px, 24px
      md: ['1.125rem', '1.75rem'], // 18px, 28px
      lg: ['1.562rem', '2.44rem'], // 20px, 32px
      'xl': ['1.938rem', '2.25rem'], // 31px, 36px
      '2xl': ['2.438rem', '2.75rem'], // 39px, 44px
      '3xl': ['3.062rem', '3.5rem'],
    },
    colors: {
      'blue': '#2530CE',
      'black': '#2E2C2C'
    },
    extend: {
      colors: {
        clifford: '#da373d',
      }
    }
  },
  plugins: [],
}
