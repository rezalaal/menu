/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')

export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      'coral-amber': '#E5CCAE',
      'coral-from': '#5F6F52',
      'coral-to': '#A9B388',
      'footer': '#527853',
      lime: colors.lime,
      black: colors.black,
      white: colors.white,
      gray: colors.gray,
      emerald: colors.emerald,
      indigo: colors.indigo,
      purple: colors.purple,
      pink: colors.pink,
      yellow: colors.yellow,
    },
    extend: {
      keyframes: {
        gradient: {
          "0%": {
            backgroundPosition: "0% 50%",
          },
          "100%": {
            backgroundPosition: "100% 50%",
          }
        }
      },
      animation:{
        gradient: "gradient 6s linear infinite"
      },
      fontFamily: {        
        'mallanna': ['"Mallanna"'],
        'iransans-regular': ['iransans-regular'],
        'iransans-black': ['iransans-black'],
        'iransans-bold': ['iransans-bold'],
        'iransans-extrabold': ['iransans-extrabold'],                        
        'iransans-thin': ['iransans-thin'],
        'iransans-ultralight': ['iransans-ultralight'],
        'dastnevis': ['dastnevis']
      },
      spacing: {
        '100px': '100px',
      },
      inset: {
        '100px': '100px',
      }
    },
  },
  plugins: [require("daisyui")],
}

