'use strict';
require('es6-promise').polyfill();
let gulp          = require("gulp");
let concat        = require("gulp-concat");
let sass          = require("gulp-sass");
let autoprefixer  = require('gulp-autoprefixer');
let uglify        = require("gulp-uglify");
let jshint        = require("gulp-jshint");
let imagemin      = require("gulp-imagemin");
let browserSync   = require('browser-sync');
let pug           = require('gulp-pug');
let combineMq     = require('gulp-combine-mq');
let sourcemaps    = require('gulp-sourcemaps');
let filter        = require('gulp-filter');
let injectSvg     = require('gulp-inject-svg');
let cleanCSS      = require('gulp-clean-css');

let reload        = browserSync.reload;


var paths = {
  html: ['category-product.html'],
  pug: ['app/pug/*.pug'],
  css: ['app/scss/**/*.scss'],
  script: ['app/js/**/*.js']
};

// ////////////////////////////////////////////////
// CSS
// ///////////////////////////////////////////////

gulp.task('sass', function () {
  gulp.src('app/scss/**/*.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({errLogToConsole: true}))
  .pipe(sass().on('error', sass.logError))
  .pipe(combineMq({
    beautify: true
  }))
  .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))

  .pipe(sourcemaps.write('../maps'))
  .pipe(cleanCSS({compatibility: 'ie8', rebase: false}))
  .pipe(gulp.dest('dist/dist'))
  .pipe(filter(['**/*.css']))  // filter the maps files so browsersync can inject css, instead of page reload
  .pipe(browserSync.stream());
});

// ////////////////////////////////////////////////
// HTML
// ///////////////////////////////////////////////
gulp.task('pug', function() {
  return gulp.src(paths.pug) //('app/jade/**/*.jade')
    .pipe(pug({
      pretty: true
      }))
    // .pipe(injectSvg()) // включать только для страниц выбора подарка
    .pipe(gulp.dest('./dist')) // указываем gulp куда положить скомпилированные HTML файлы
    .pipe(reload({stream:true}));
});
// ////////////////////////////////////////////////
// JavaScript
// ///////////////////////////////////////////////
gulp.task('scripts', function() {
  gulp.src('app/js/**/*.js')
    // .pipe(jshint())
    // .pipe(jshint.reporter('default'))
    // .pipe(concat('all.js'))
    // .pipe(uglify())
    .pipe(gulp.dest('dist/dist/js'))
    // .pipe(reload({stream:true}));
});
// ////////////////////////////////////////////////
// Images
// ///////////////////////////////////////////////
gulp.task('images', function() {
  return gulp.src('app/img/**/*')
  .pipe(imagemin())
  .pipe(gulp.dest('dist/dist/images'));
});
// ***********************
// Browser Syncronize
// ***********************
gulp.task('browserSync', function() {
  browserSync({
    server: {
      baseDir: "./dist/",
      index: paths.html
    },
    port: 8080,
    open: true,
    notify: false,
    reloadDelay: 300
  });
});

gulp.task('watcher',function(){
  gulp.watch(paths.css, ['sass']);
  gulp.watch(paths.script, ['scripts']);
  gulp.watch(paths.pug, ['pug']);
});


gulp.task('default', ['scripts', 'pug', 'images', 'sass', 'watcher', 'browserSync']);
