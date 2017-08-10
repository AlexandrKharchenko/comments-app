let mix = require('laravel-mix');

mix.js('resource/assets/vue-application/vue.app.js', 'public/assets/js')
    .sass('resource/assets/scss/app.scss', 'public/assets/css')
