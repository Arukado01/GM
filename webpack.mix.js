let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js/app.min.js')
    .js('resources/assets/js/admin_app.js', 'public/admin/js/admin_core.min.js')
    .sass('resources/assets/sass/admin_core.scss', 'public/admin/css/admin_core.min.css')
    .sass('resources/assets/sass/app.scss', 'public/css/app.min.css');
