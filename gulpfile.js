'use strict';
require('es6-promise').polyfill();
var gulp = require("gulp");
var concat = require("gulp-concat");
var sass = require("gulp-sass");
var autoprefixer = require('gulp-autoprefixer');
var uglify = require("gulp-uglify");
var jshint = require("gulp-jshint");
var imagemin = require("gulp-imagemin");
var browsersync = require('browser-sync');
var pug = require('gulp-pug');
// CSS processing

// gulp.task('compass', function() {
//   gulp.src('./app/scss/*.scss')
//     .pipe(compass({
//       config_file: './config.rb',
//       sourcemap: true,
//       debug : true,
//       css: 'dist',
//       sass: 'app/scss'
//     }))
//     .pipe(gulp.dest('app/assets/temp'));
// });

gulp.task('sass', function () {
  gulp.src('app/scss/**/*.scss')
    .pipe(sass({errLogToConsole: true}))
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
    .pipe(gulp.dest('dist'));
});
// ***********************
// HTML processing
// ***********************
gulp.task('pug', function() {
    return gulp.src('app/pug/category-product.pug') //('app/jade/**/*.jade')
        .pipe(pug({
            pretty: true
            })) 
        .pipe(gulp.dest('.')); // указываем gulp куда положить скомпилированные HTML файлы
});
// ***********************
// JavaScript processing
// ***********************
gulp.task('scripts', function() {
    gulp.src('app/js/pages/*.js')
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    // .pipe(concat('all.js'))
    // .pipe(uglify())
    .pipe(gulp.dest('dist/js'))
});
// ***********************
// Images processing
// ***********************
gulp.task('images', function() {
    return gulp.src('app/img/**/*')
    .pipe(imagemin())
    .pipe(gulp.dest('dist/images'));
});
// ***********************
// Browser Syncronize
// ***********************
gulp.task('browsersync', function(cb) {
    return browsersync({
    server: {
            baseDir:'./',
            index: 'category-product.html'
        },
    reloadDelay: 300

    }, cb);
});


gulp.task('watch', function () {
    gulp.watch('app/scss/**/*.scss', ['sass', browsersync.reload]);
    gulp.watch('app/pug/**/*.pug', ['pug', browsersync.reload]);
    gulp.watch('app/js/**/*.js', ['scripts', browsersync.reload]);
    // gulp.watch('app/img/*', ['images', browsersync.reload]);
});


gulp.task('default', ['sass', 'pug', 'scripts', 'images', 'browsersync', 'watch']);
