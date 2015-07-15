var elixir = require('laravel-elixir');
require('laravel-elixir-stylus');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss')
        .stylus('main.styl', 'resources/assets/css')

        .styles([
         /*'chosen.min.css',
         'tooltipster.css',
         'themes/tooltipster-diamante.css',
         'magnific-popup.css',
         'li-scroller.css',
         'lightbox.css',*/
         'animate.css',
         'starrr.css',
         'magnific-popup.css',
         'select2.css',
         'main.css'
         ],'public/css/bundle.css','resources/assets/css')

        .styles([
            'magnific-popup.css',
            'admin.css'
        ],'public/css/backend.css','resources/assets/css')

        .scripts([
         'jquery-1.11.1.min.js',
         'jquery.cycle2.min.js',
         'jquery.hoverIntent.minified.js',
         'jquery.magnific-popup.min.js',
         'select2.min.js',
         'handlebars-v3.0.3.js',
         'lightbox.min.js',
         'ajaxupload.js',
         'expanding.js',
         'starrr.js',
         'holder.js',
         'main.js'
         ],'public/js/bundle.js','resources/assets/js')

        .scripts([
            //'jquery-1.11.1.min.js',
            //'lightbox.min.js',
            'jquery.magnific-popup.min.js',
            'handlebars-v3.0.3.js',
            'ajaxupload.js',
            'holder.js',
            'admin.js'
        ],'public/js/backend.js','resources/assets/js')

        .version([
            'public/css/bundle.css',
            'public/css/backend.css',
            'public/js/bundle.js',
            'public/js/backend.js'
        ]);
});
