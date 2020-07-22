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
    'public/assets/js/plugins/moment/moment.js',
    'public/assets/js/plugins/speed/refresh.min.js',
    'public/assets/js/plugins/firebase/firebase.js',
    'public/assets/js/plugins/speed/lite.min.js',
    'public/assets/js/plugins/speed/trasher.min.js',
    'public/assets/js/plugins/speed/vy-dep-trai.js',
    'public/assets/js/vue/vue.js',
    'public/assets/js/site.min.js',
],'public/js/vendor.min.js').version();


mix.scripts([
    'public/assets/js/wheel/throw.min.js',
    'public/assets/js/wheel/wheel.js',
    'public/assets/js/wheel/index.js',
],'public/js/w.min.js');

mix.styles([
    'public/assets/css/animate.min.css',
    'public/assets/css/site.min.css',
    'public/assets/css/static.css',
    'public/assets/css/style.css',
    'public/assets/css/toast.min.css',
],'public/css/app.min.css').version();
