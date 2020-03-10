const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.scripts([
    'public/assets/js/plugins/socket/socket.io.js',
    'public/assets/js/plugins/axios/axios.min.js',
    'public/assets/js/plugins/firebase/firebase.js',
    'public/assets/js/plugins/moment/moment.js',
    'public/assets/js/plugins/speed/lite.min.js',
    'public/assets/js/plugins/speed/refresh.min.js',
    'public/assets/js/plugins/speed/trasher.js',
    'public/assets/js/vue/vue.js',
    'public/assets/js/wheel/index.js',
    'public/assets/js/wheel/throw.js',
    'public/assets/js/wheel/wheel.js',
    'public/assets/js/site.min.js',
],'public/js/vendor.js');



