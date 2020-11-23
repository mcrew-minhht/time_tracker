const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.autoload({ 'jquery': ['window.$', 'window.jQuery'] })
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);
mix.js('resources/js/common.js', 'public/js');
mix.styles('resources/css/style.css', 'public/css/style.css');
mix.styles('resources/css/pdf.css', 'public/css/pdf.css');
