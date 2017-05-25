let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix
    .setPublicPath('./dist')
    .options({
        processCssUrls: false
    })

    // .copyDirectory('assets/fonts', 'fonts')

    // do not remove next 2 lines
    // this line is for `npm run dev`
    .copyDirectory('assets/images', 'dist/images')
    //this line is necessary for `npm run hot`
    .copyDirectory('assets/images', 'images')
    .copyDirectory('assets/sounds', 'dist/sounds')
    .js('assets/js/app.js', 'js/')
    .sass('assets/scss/theme.scss', 'css')
    .sass('assets/scss/vendor.scss', 'css');


let dotenv = require('dotenv').config({path: '../../.env'});

mix.browserSync({
    proxy: process.env.APP_URL,
    host: process.env.APP_URL,
    notify: false,
    files: [
        './dist/js/**/*.js',
        './dist/js/**/*.vue',
        './dist/css/*.css',
        './**/*.scss',
        './**/*.htm'
    ]
});

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.standaloneSass('src', output); <-- Faster, but isolated from Webpack.
// mix.less(src, output);
// mix.stylus(src, output);
// mix.browserSync('my-site.dev');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   uglify: {}, // Uglify-specific options. https://webpack.github.io/docs/list-of-plugins.html#uglifyjsplugin
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
