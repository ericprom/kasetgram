const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

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

elixir(mix => {

    mix
    	.copy('./node_modules/font-awesome/fonts', 'public/fonts')
        .copy('./resources/assets/avatars', 'public/avatars')
        .copy('./resources/assets/images', 'public/images')
    	.sass('app.scss')
       	.webpack('app.js');
});