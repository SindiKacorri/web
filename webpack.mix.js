let mix = require('laravel-mix');

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

/**
 * FRONT STYLE
 */

mix.combine([
    'resources/assets/libs/css/owl.carousel.min.css',
    'resources/assets/libs/css/toastr.min.css'
], 'public/front/css/libs.css')

.combine([
    'resources/assets/front/css/grid.css',
    'resources/assets/front/css/global.css',
    'resources/assets/front/css/nav.css',
    'resources/assets/front/css/footer.css',
    'resources/assets/front/css/main.css'
], 'public/front/css/ltd.css')

/**
* FRONT SCRIPTS
*/

.combine([
    'resources/assets/libs/js/owl.carousel.min.js',
    'resources/assets/libs/js/toastr.min.js'
], 'public/front/js/libs.js')

.combine([
    'resources/assets/front/js/main.js'
], 'public/front/js/jaal.js')



/**
* AUTHENTICATION
*/
.combine([
    'resources/assets/assetes/css/bootstrap-3.3.7.css',
    'resources/assets/back/css/login.css',
], 'public/back/css/login.css')


/**
* backend STYLES AND SCRIPTS
*/

.combine([
    'resources/assets/back/css/dashboard/purple.css',
    'resources/assets/libs/css/toastr.min.css',
    'resources/assets/back/css/dashboard/sweetalert.min.css',
    'resources/assets/libs/css/colorpicker.css',
    'resources/assets/libs/css/dropzone.css',
    'resources/assets/libs/css/select2.min.css',
    'resources/assets/back/css/dashboard/adminLte.css',
    'resources/assets/back/css/custom.css'
    ],'public/back/css/dashboard.css')

.combine([
    'resources/assets/libs/js/fastclick.js',
    'resources/assets/libs/js/toastr.min.js',
    'resources/assets/libs/js/sweetalert.min.js',
    'resources/assets/libs/js/slimscroll.min.js',
    'resources/assets/libs/js/colorpicker.js',
    'resources/assets/libs/js/select2.min.js',
    'resources/assets/back/js/app.js',
    ],'public/back/js/dashboard.js')

.babel([
    'resources/assets/libs/js/exif.js',
    // 'resources/assets/libs/js/load-image.js',
    'resources/assets/back/js/custom.js',
], 'public/back/js/dz.js')

.babel([
    'resources/assets/back/js/new-product.js'
], 'public/back/js/new-product.js')

.babel([
    'resources/assets/back/js/edit-product.js'
], 'public/back/js/edit-product.js')

.combine([
    'resources/assets/libs/js/dropzone.min.js',
], 'public/back/js/dropzone.js')

.babel([
    'resources/assets/front/js/jaal.js'
], 'public/front/app.js')

.babel([
        'resources/assets/front/js/search.js'
    ], 'public/front/search.js')

.copy('resources/assets/img', 'public/src');

if(mix.inProduction()) {
    mix.version();
}