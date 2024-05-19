/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: ["./views/**/*.twig"],
  theme: {
    fontFamily: {
      sans: ["nimbus-sans", ...defaultTheme.fontFamily.sans],
      extended: ["nimbus-sans-extended", ...defaultTheme.fontFamily.sans],
    },
    screens: {
      sm: "640px",
      md: "768px",
      lg: "1024px",
      xl: "1280px",
      "2xl": "1536px",
    },
    fontSize: {
      xs: ["0.6875rem", "1.25rem"], // 10px
      sm: ["0.875rem", "1.25rem"], // 14px, 20px
      base: ["1rem", "1.375rem"], // 16px, 22px
      md: ["1.125rem", "1.5rem"], // 18px, 4px
      lg: ["1.5625rem", "2.25rem"], // 25px, 36px
      xl: ["1.9375rem", "2.625rem"], // 31px, 42px
      "2xl": ["2.4375rem", "3rem"], // 39px, 48px
      "3xl": ["3.0625rem", "3.75rem"], // 49px, 48px
    },
    extend: {
      colors: {
        "blue-400": "#4D6AF5",
        blue: "#084FF9",
        "blue-600": "#1401D3",
        "blue-700": "#060674",
        black: "#2E2C2C",
        "grey-100": "#E5E5E5"
      },
      screens: {
        'xs': '512px'
      },
    },
  },
  plugins: [require("@tailwindcss/typography")],
};
