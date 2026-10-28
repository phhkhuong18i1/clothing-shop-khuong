import forms from '@tailwindcss/forms';

export default {
    content: ['./resources/**/*.blade.php', './resources/**/*.js'],
    theme: { extend: { colors: { ink: '#20201d', paper: '#f7f5f0', clay: '#a6684f', olive: '#6e7258' }, fontFamily: { sans: ['Inter', 'sans-serif'], display: ['Playfair Display', 'serif'] } } },
    plugins: [forms],
};
