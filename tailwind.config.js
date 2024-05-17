/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/**/*.twig"],
  theme: {
    fontFamily: {
      sans: ["nimbus_sans_lregular"],
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
      base: ["1rem", "1.5rem"], // 16px, 24px
      md: ["1.125rem", "1.75rem"], // 18px, 28px
      lg: ["1.5625rem", "2.25rem"], // 25px, 36px
      xl: ["1.9375rem", "2.625rem"], // 31px, 42px
      "2xl": ["2.4375rem", "3rem"], // 39px, 48px
      "3xl": ["3.0625rem", "3.75rem"], // 49px, 48px
    },
    extend: {
      colors: {
        blue: "#084FF9",
        "blue-dark": "#060674",
        black: "#2E2C2C",
      },
    },
  },
  plugins: [require("@tailwindcss/typography")],
};
