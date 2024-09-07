import defaultTheme from 'tailwindcss/defaultTheme';
import colors from 'tailwindcss/colors';
import forms from '@tailwindcss/forms';

export default {
  content: [
    './app/Front/**/*.php',
    './app/Livewire/**/*.php',
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/wireui/wireui/src/*.php",
    "./vendor/wireui/wireui/ts/**/*.ts",
    "./vendor/wireui/wireui/src/WireUi/**/*.php",
    "./vendor/wireui/wireui/src/Components/**/*.php",
  ],
  presets: [
    require('./vendor/wireui/wireui/tailwind.config.js')
  ],
  theme: {
    extend: {
      colors: {
        primary: colors.teal,
        secondary: colors.gray,
        positive: colors.emerald,
        negative: colors.red,
        warning: colors.amber,
        info: colors.blue
      },
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    // ...
    require('@tailwindcss/forms'),
  ],
  safelist: [
    'col-span-1',
    'col-span-2',
    'col-span-3',
    'col-span-4',
    'col-span-5',
    'col-span-6',
    'col-span-7',
    'col-span-8',
    'col-span-9',
    'col-span-10',
    'col-span-11',
    'col-span-12',
  ]
}
