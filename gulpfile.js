'use strict';

var gulp = require('gulp');
var less = require('gulp-less');
var minifyCSS = require('gulp-csso');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var mainBowerFiles = require('main-bower-files');
var babel = require('gulp-babel');
var uglify = require('gulp-uglify');
var watch = require('gulp-watch');
var flatten = require('gulp-flatten');
var debug = require('gulp-debug');
var plumber = require('gulp-plumber');

gulp.task('fonts', function() {
    return gulp.src('resources/assets/admin/bower_components/*/fonts/*.{eot,svg,ttf,woff,woff2}')
        .pipe(flatten())
        .pipe(gulp.dest('public/assets/admin/fonts'));
});

gulp.task('vendors:js', function() {
    return gulp.src(mainBowerFiles('**/*.js'), { base: 'resources/assets/admin/bower_components' })
        // .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(concat('vendor.js'))
        // .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/assets/admin/vendor'));
});

gulp.task('vendors:css', function() {
    return gulp.src(mainBowerFiles('**/*.{css,less}'), { base: 'resources/assets/admin/bower_components' })
        .pipe(less())
        // .pipe(sourcemaps.init())
        .pipe(minifyCSS())
        .pipe(concat('vendor.css'))
        // .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/assets/admin/vendor'));
});

gulp.task('js', function() {
    return gulp.src(['resources/assets/admin/libs/**/*.js', 'resources/assets/admin/js/**/*.js'])
        .pipe(plumber())
        // .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(uglify())
        .pipe(concat('app.js'))
        // .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/assets/admin'));
});

gulp.task('css', function() {
    return gulp.src(['resources/assets/admin/css/sb/*.less', 'resources/assets/admin/css/**/*.less'])
        .pipe(plumber())
        .pipe(less())
        // .pipe(sourcemaps.init())
        .pipe(minifyCSS())
        .pipe(concat('app.css'))
        // .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/assets/admin'));
});

gulp.task('watch', function() {
    gulp.watch('resources/assets/admin/css/**/*.less', ['css']);
    gulp.watch('resources/assets/admin/js/**/*.js', ['js']);
});

gulp.task('default', ['fonts', 'vendors:js', 'vendors:css', 'js', 'css', 'watch']);


