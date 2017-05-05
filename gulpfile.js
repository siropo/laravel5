var elixir = require('laravel-elixir');

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

elixir(function(mix) {

    //mix.phpUnit();

    mix.sass('app.scss');

    mix.styles([
        'vendor/normalize.css',
        'app.css'
    ], null, 'public/css');

    // Combine scripts
    mix.scripts([
        'globals.js',
        'app.js',
        'helpers.js',
        'options.js',
        'fetch_categories.js',
        'forms.js'
    ], 'public/js/app.js')
        .scripts(['create_ads.js'],
            'public/js/create_ads.js')
        .scripts(['edit_ads.js'],
            'public/js/edit_ads.js');


    mix.version(['public/css/all.css',
        'public/js/app.js',
        'public/js/create_ads.js',
        'public/js/edit_ads.js']);

});
