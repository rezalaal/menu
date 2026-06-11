import { lime as _lime, red as _red, black as _black, white as _white, gray as _gray, emerald as _emerald, indigo as _indigo, purple as _purple, pink as _pink, yellow as _yellow } from 'tailwindcss/colors'

export const content = [
  "./resources/**/*.blade.php",
  "./resources/**/*.js",
  "./resources/**/*.vue",
]

export const theme = {
  colors: {
    transparent: 'transparent',
    current: 'currentColor',
        'coral-dark': '#3D4A34',
        'coral-from': '#5F6F52',
        'coral-mid': '#819171',
        'coral-to': '#A9B388',
        'coral-header': '#D1DFB7',
        'footer': '#3D4A34',
        'coral': '#D4826A',
        'coral-body': '#F8F5EF',
        'coral-amber': '#E5CCAE',
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
    red: _red,
  },
    extend: {
        keyframes: {
            gradient: {
                "0%": { backgroundPosition: "0% 50%" },
                "100%": { backgroundPosition: "100% 50%" }
            },
            "fade-in-up": {
                "0%": { opacity: "0", transform: "translateY(20px)" },
                "100%": { opacity: "1", transform: "translateY(0)" }
            },
            "fade-in": {
                "0%": { opacity: "0" },
                "100%": { opacity: "1" }
            },
            "slide-in-right": {
                "0%": { transform: "translateX(100%)", opacity: "0" },
                "100%": { transform: "translateX(0)", opacity: "1" }
            },
            "slide-in-left": {
                "0%": { transform: "translateX(-100%)", opacity: "0" },
                "100%": { transform: "translateX(0)", opacity: "1" }
            },
            "scale-in": {
                "0%": { transform: "scale(0.9)", opacity: "0" },
                "100%": { transform: "scale(1)", opacity: "1" }
            },
            "pulse-glow": {
                "0%, 100%": { boxShadow: "0 0 5px rgba(162, 202, 108, 0.4)" },
                "50%": { boxShadow: "0 0 20px rgba(162, 202, 108, 0.8)" }
            },
            "float": {
                "0%, 100%": { transform: "translateY(0)" },
                "50%": { transform: "translateY(-6px)" }
            },
            "shimmer": {
                "0%": { backgroundPosition: "-200% 0" },
                "100%": { backgroundPosition: "200% 0" }
            }
        },
        animation: {
            gradient: "gradient 6s linear infinite",
            "fade-in-up": "fade-in-up 0.5s ease-out",
            "fade-in": "fade-in 0.3s ease-out",
            "slide-in-right": "slide-in-right 0.4s ease-out",
            "slide-in-left": "slide-in-left 0.4s ease-out",
            "scale-in": "scale-in 0.3s ease-out",
            "pulse-glow": "pulse-glow 2s ease-in-out infinite",
            "float": "float 3s ease-in-out infinite",
            "shimmer": "shimmer 2s linear infinite"
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
            '999': '999',
        },
        backgroundImage: {
            'gradient-brand': 'linear-gradient(135deg, #5F6F52 0%, #819171 100%)',
            'gradient-warm': 'linear-gradient(135deg, #F8F5EF 0%, #E5CCAE 100%)',
            'gradient-header': 'linear-gradient(135deg, #D1DFB7 0%, #A9B388 100%)',
            'gradient-footer': 'linear-gradient(135deg, #3D4A34 0%, #5F6F52 100%)',
            'shimmer': 'linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.05) 50%, transparent 100%)'
        },
        boxShadow: {
            'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
            'glow': '0 0 15px rgba(212, 130, 106, 0.3)',
            'glow-lg': '0 0 30px rgba(212, 130, 106, 0.4)',
            'inner-glow': 'inset 0 2px 4px 0 rgba(212, 130, 106, 0.1)'
        },
        borderRadius: {
            '4xl': '2rem',
        }
    },
}
export const plugins = []
