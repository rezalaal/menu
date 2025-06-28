import { lime as _lime, black as _black, white as _white, gray as _gray, emerald as _emerald, indigo as _indigo, purple as _purple, pink as _pink, yellow as _yellow } from 'tailwindcss/colors'

export const content = [
  "./resources/**/*.blade.php",
  "./resources/**/*.js",
  "./resources/**/*.vue",
]

export const theme = {
  colors: {
    transparent: 'transparent',
    current: 'currentColor',
    'coral-amber': '#E5CCAE',
    'coral-from': '#5F6F52',
    'coral-to': '#A9B388',
    'footer': '#527853',
    'coral': '#a2ca6c',
    'coral-body': '#f2e8cf',
    'coral-header': '#c7dfa7',
      /*
      *'coral': '#F88378',377771
      *
      *
      * */
    lime: _lime,
    black: _black,
    white: _white,
    gray: _gray,
    emerald: _emerald,
    indigo: _indigo,
    purple: _purple,
    pink: _pink,
    yellow: _yellow,
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
    animation: {
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
    },
    zIndex: {
          '60': '60',
          '70': '70',
          '80': '80',
          '90': '90',
          '100': '100',
          // می‌تونی هر مقدار دلخواهی اضافه کنی
          '999': '999',
      }
  },
}
export const plugins = []
