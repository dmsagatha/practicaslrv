/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    colors: {
      transparent: 'transparent',
      current: 'currentColor',

      // Paleta predeterminada de olores
      slate: colors.slate,
      gray: colors.gray,
      zinc: colors.zinc,
      neutral: colors.neutral,
      stone: colors.stone,
      red: colors.red,
      orange: colors.orange,
      amber: colors.amber,
      yellow: colors.yellow,
      lime: colors.lime,
      green: colors.green,
      emerald: colors.emerald,
      teal: colors.teal,
      cyan: colors.cyan,
      sky: colors.sky,
      indigo: colors.indigo,
      violet: colors.violet,
      purple: colors.purple,
      fuchsia: colors.fuchsia,
      pink: colors.pink,
      rose: colors.rose,
      black: colors.black,
      white: colors.white,
      
      // Colores personalizados
      'blue': {
        '50': '#f5f8fa', 
        '100': '#ecf1f5', 
        '200': '#cfdce6', 
        '300': '#b2c7d7', 
        '400': '#799cb9', 
        '500': '#3f729b', 
        '600': '#39678c', 
        '700': '#2f5674', 
        '800': '#26445d', 
        '900': '#1f384c'
      },
      'midnight': '#121063',
      'metal': '#565584',
      'tahiti': '#3ab7bf',
      'silver': '#ecebff',
      'bubble-gum': '#ff77e9',
      'bermuda': '#78dcca',
    },
    fontFamily: {
      sans: ['Poppins', 'sans-serif'],
      display: ['Poppins', 'sans-serif'],
      body: ['Poppins', 'sans-serif']
    },
    extend: {},
  },
  plugins: [
    // require('@tailwindcss/forms')
  ]
}