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

 let publicPath = 'public/';
 let resourcesPath = 'resources';

mix.js('resources/js/app.js', 'public/js/init.js')
    .vue()
    .postCss('resources/css/app.css', 'public/css/init.css')
    .combine([
        'public/css/init.css',
        publicPath + 'admin/app-assets/vendors/css/vendors-rtl.min.css',
        publicPath + 'admin/app-assets/css-rtl/bootstrap.css',
        publicPath + 'admin/app-assets/css-rtl/bootstrap-extended.css',
        publicPath + 'admin/app-assets/css-rtl/colors.css',
        publicPath + 'admin/app-assets/css-rtl/components.css',
        publicPath + 'admin/app-assets/css-rtl/themes/dark-layout.css',
        publicPath + 'admin/app-assets/css-rtl/themes/semi-dark-layout.css',
        publicPath + 'admin/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css',
        publicPath + 'admin/app-assets/css-rtl/core/colors/palette-gradient.css',
        publicPath + 'admin/app-assets/css-rtl/pages/dashboard-ecommerce.css',
        publicPath + 'admin/app-assets/css-rtl/pages/card-analytics.css',
        publicPath + 'admin/app-assets/css-rtl/custom-rtl.css',
        publicPath + 'admin/assets/css/style-rtl.css',
        publicPath + 'admin/assets/css/style.css',
        publicPath + 'admin/app-assets/css/jquery_ui.min.css',
        publicPath + 'admin/app-assets/vendors/css/extensions/toastr.css',
        publicPath + 'admin/app-assets/css-rtl/plugins/extensions/toastr.css',
    ],'public/css/rtl.css')
    .combine([
        'public/css/init.css',
        publicPath + 'admin/app-assets/vendors/css/vendors.min.css',
        publicPath + 'admin/app-assets/css/bootstrap.css',
        publicPath + 'admin/app-assets/css/bootstrap-extended.css',
        publicPath + 'admin/app-assets/css/colors.css',
        publicPath + 'admin/app-assets/css/components.css',
        publicPath + 'admin/app-assets/css/themes/dark-layout.css',
        publicPath + 'admin/app-assets/css/themes/semi-dark-layout.css',
        publicPath + 'admin/app-assets/css/core/menu/menu-types/vertical-menu.css',
        publicPath + 'admin/app-assets/css/core/colors/palette-gradient.css',
        publicPath + 'admin/app-assets/css/pages/dashboard-ecommerce.css',
        publicPath + 'admin/app-assets/css/pages/card-analytics.css',
        // publicPath + 'admin/app-assets/css/custom-rtl.css',
        publicPath + 'admin/assets/css/style_en.css',
        publicPath + 'admin/assets/css/style.css',
        publicPath + 'admin/app-assets/css/jquery_ui.min.css',
        publicPath + 'admin/app-assets/vendors/css/extensions/toastr.css',
        publicPath + 'admin/app-assets/css-rtl/plugins/extensions/toastr.css',
    ],'public/css/app.css')
    .combine([
        publicPath + 'js/init.js',
        publicPath + 'admin/assets/js/flatpickr.js',
        publicPath + 'admin/app-assets/vendors/js/vendors.min.js',
        publicPath + 'admin/app-assets/js/core/app-menu.js',
        publicPath + 'admin/app-assets/js/core/app.js',
        publicPath + 'admin/app-assets/js/scripts/components.js',
        publicPath + 'admin/app-assets/vendors/js/extensions/toastr.min.js',
    ],'public/js/app.js');
