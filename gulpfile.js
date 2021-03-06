var elixir = require('laravel-elixir');
// require('laravel-elixir-codeception');

process.env.DISABLE_NOTIFIER = true;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.webpack('maps-entry.js', 'public/assets/js/compiled/maps-entry.js');
    mix.webpack('maps-home.js', 'public/assets/js/compiled/maps-home.js');

    mix.sass(['app.scss', 'essentials.scss'], 'public/assets/css/compiled');
    mix.sass(['map.scss'], 'public/assets/css/compiled/map.css');

    mix.sass('color_scheme/darkBlue.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/oceanBlue.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/lightBlue.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/orange.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/blue.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/purple.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/brown.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/cyan.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/amber.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/gray.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/lime.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/darkGray.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/black.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/white_blue.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/white_gray.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/white_green.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/white_orange.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/white_pink.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/black_white.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/green.scss', 'public/assets/css/color_scheme');
    mix.sass('color_scheme/purple_pink.scss', 'public/assets/css/color_scheme');

    // mix.codeception();
});
