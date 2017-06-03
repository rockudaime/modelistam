'use strict';
require('es6-promise').polyfill();
var gulp          = require("gulp");
var concat        = require("gulp-concat");
var sass          = require("gulp-sass");
var autoprefixer  = require('gulp-autoprefixer');
var uglify        = require("gulp-uglify");
var jshint        = require("gulp-jshint");
var imagemin      = require("gulp-imagemin");
var browserSync   = require('browser-sync');
var pug           = require('gulp-pug');
var combineMq     = require('gulp-combine-mq');
var sourcemaps    = require('gulp-sourcemaps');
var filter        = require('gulp-filter');
var injectSvg     = require('gulp-inject-svg');

var reload        = browserSync.reload;


var paths = {
  html: ['search.html'],
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
  // .pipe(sass().on('error', sass.logError))
  .pipe(combineMq({
    beautify: true
  }))
  .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
  
  .pipe(sourcemaps.write('../maps'))
  .pipe(gulp.dest('dist'))
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
    .pipe(gulp.dest('.')) // указываем gulp куда положить скомпилированные HTML файлы
    .pipe(reload({stream:true}));
});
// ////////////////////////////////////////////////
// JavaScript 
// ///////////////////////////////////////////////
gulp.task('scripts', function() {
  gulp.src('app/js/**/*.js')
    .pipe(jshint())
    // .pipe(jshint.reporter('default'))
    // .pipe(concat('all.js'))
    // .pipe(uglify())
    .pipe(gulp.dest('dist/js/'))
    .pipe(reload({stream:true}));
});
// ////////////////////////////////////////////////
// Images
// ///////////////////////////////////////////////
gulp.task('images', function() {
  return gulp.src('app/img/**/*')
  .pipe(imagemin())
  .pipe(gulp.dest('dist/images'));
});
// ***********************
// Browser Syncronize
// ***********************
gulp.task('browserSync', function() {
  browserSync({
    server: {
      baseDir: "./",
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
