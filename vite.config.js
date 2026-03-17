import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/client.css',
                'resources/css/contact.css',
                'resources/css/Services.css',
                'resources/css/about.css',
                'resources/css/chat.css',
                'resources/css/dashboard.css',
                'resources/js/about.js',
                'resources/js/app.js',
                'resources/js/blog.js',
                'resources/js/chart.js',
                'resources/js/chat.js',
                'resources/js/client.js',
                'resources/js/DashForum.js',
                'resources/js/echo.js',
                'resources/js/forms.js',
                'resources/js/hero.js',
                'resources/js/home.js',
                'resources/js/navbar.js',
                'resources/js/notification.js',
                'resources/js/services.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
