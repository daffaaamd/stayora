/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                gold: {
                    50: '#FBF7EF',
                    100: '#F5ECDA',
                    200: '#EBD7B3',
                    300: '#DDBF86',
                    400: '#CFA85E',
                    500: '#B8860B',
                    600: '#9A710A',
                    700: '#7B5A08',
                    800: '#5D4406',
                    900: '#3E2D04',
                },
                charcoal: {
                    50: '#F5F5F5',
                    100: '#E8E8E8',
                    200: '#D1D1D1',
                    300: '#B0B0B0',
                    400: '#888888',
                    500: '#6D6D6D',
                    600: '#5D5D5D',
                    700: '#4A4A4A',
                    800: '#2D2D2D',
                    900: '#1A1A1A',
                },
                warm: {
                    50: '#FDFCFB',
                    100: '#F8F7F4',
                    200: '#F0EEEA',
                    300: '#E4E1DC',
                    400: '#C8C3BA',
                },
            },
            fontFamily: {
                'display': ['Playfair Display', 'Georgia', 'serif'],
                'body': ['Inter', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
