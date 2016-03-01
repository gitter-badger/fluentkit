var fs = require('fs'),
    elixir = require('laravel-elixir'),
    gulp = require("gulp"),
    gutil = require("gulp-util"),
    sourcemaps = require('gulp-sourcemaps'),
    jspm = require('jspm'),
    babel = require('gulp-babel'),
    uglify = require('gulp-uglify'),
    header = require('gulp-header'),
    exec = require('child_process').exec;


jspm.setPackagePath('.');

var fluentkit = JSON.parse(fs.readFileSync('./composer.json'));

var banner =
    '/*!\n' +
    ' * FluentKit v' + fluentkit.version + '\n' +
    ' * (c) ' + new Date().getFullYear() + ' Lee Mason\n' +
    ' * Released under the MIT License.\n' +
    ' */\n';


/**
 * babelify es6 modules into system js, so even in dev we aren't transpiling!
 */
gulp.task('babel', function(){
    return gulp.src('resources/assets/js/**/*.js')
        .pipe(header(banner))
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['es2015'],
            plugins: ['transform-es2015-modules-systemjs']
        }))
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/js'));
});

gulp.task('routes', function(cb){

    exec('php artisan laroute:generate', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
    });

    return gulp.src('public/js/routes.js')
        .pipe(header(banner))
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/js'));
});

/**
 * jspm bundle our files for production!
 */
gulp.task('build', function(){

    // bundle everything the app needs to run - any admin dependencies
    jspm.bundle('fluentkit.js - components/admin/**/*.js', 'public/js/fluentkit.bundle.js', { mangle: true, minify: true, sourceMaps: true, inject: true }).then(function() {
        gutil.log('fluentkit.bundle.js generated');

        // bundle up the admin deps as a separate bundle so its only loaded in the admin area
        jspm.bundle('components/admin/**/*.js - fluentkit.bundle.js', 'public/js/admin.bundle.js', { mangle: true, minify: true, sourceMaps: true, inject: true }).then(function() {
            gutil.log('admin.bundle.js generated');
        });

    });

});

elixir(function(mix) {
    mix.sass('auth.scss')
        .sass('admin.scss')
        .copy('node_modules/material-design-lite/src/images', 'public/images/material')
        .task('babel', 'resources/assets/js/**/*.js')
        .task('routes');

});