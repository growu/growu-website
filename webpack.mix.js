const { mix } = require('laravel-mix');

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

// mix.js('resources/assets/js/app.js', 'public/js')
//     .extract(['jquery','bootstrap-sass','admin-lte'])
//     .sass('resources/assets/sass/app.scss', 'public/css')
//     .less('resources/assets/sass/app.less', 'public/css');

if (mix.config.inProduction) {

} else {
    // mix.copy('node_modules/bootstrap/css/bootstrap.css', 'public/css/');
    // mix.js('node_modules/jquery/dist/jquery.js', 'public/js')
    // mix.js('node_modules/bootstrap/js/bootstrap.js', 'public/js')
    // mix.js('node_modules/admin-lte/dist/js/app.js', 'public/js')

    // mix.extract([
    //     'node_modules/jquery/dist/jquery.js',
    //     'node_modules/bootstrap/js/bootstrap.js',
    //     'node_modules/admin-lte/dist/js/app.js'
    // ], 'public/js/vendor.js');
    mix.styles([
        'node_modules/bootstrap/dist/css/bootstrap.css',
        'node_modules/admin-lte/dist/css/AdminLTE.css',
        'resources/assets/css/app.css',
        'resources/assets/css/iconfont.css',
    ], 'public/css/app.css');
    
    mix.js('resources/assets/js/app.js', 'public/js')
        .extract(['jquery','bootstrap','admin-lte']);

    mix.copy('resources/assets/img/*', 'public/img');
    mix.copy('resources/assets/fonts/*', 'public/fonts');

}

// if (mix.config.inProduction) {
    mix.version();
// }

