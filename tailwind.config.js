/** @type {import('tailwindcss').Config} */
export default {
  content: ['./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}'],
  theme: {
    extend: {
      colors: {
        primary: '#E05A1A',
        dark: {
          DEFAULT: '#080808',
          secondary: '#111111',
          tertiary: '#1A1A1A',
        },
        gray: {
          DEFAULT: '#888888',
          light: '#C8C8C8',
        },
        white: '#FFFFFF',
      },
      fontFamily: {
        body: ['Gantari', 'sans-serif'],
        heading: ['Gantari', 'sans-serif'],
      },
      fontSize: {
        'xs': ['0.75rem', { lineHeight: '1rem' }],
        'sm': ['0.875rem', { lineHeight: '1.25rem' }],
        'base': ['1rem', { lineHeight: '1.5rem' }],
        'lg': ['1.125rem', { lineHeight: '1.75rem' }],
        'xl': ['1.25rem', { lineHeight: '1.75rem' }],
        '2xl': ['1.5rem', { lineHeight: '2rem' }],
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
        '5xl': ['3rem', { lineHeight: '1.1' }],
        '6xl': ['3.75rem', { lineHeight: '1.1' }],
        '7xl': ['4.5rem', { lineHeight: '1' }],
      },
      spacing: {
        'breathing': '6rem',
      },
      borderRadius: {
        'none': '0',
        'xs': '0.125rem',
        'sm': '0.25rem',
        'base': '0.5rem',
      },
      boxShadow: {
        'premium': '0 20px 60px rgba(0, 0, 0, 0.4)',
        'subtle': '0 4px 12px rgba(0, 0, 0, 0.2)',
        'inner-light': 'inset 0 1px 0 rgba(255, 255, 255, 0.05)',
      },
      backgroundImage: {
        'gradient-orange': 'linear-gradient(135deg, #E05A1A 0%, #D64715 100%)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
};
