var gulp = require('gulp');
var autoprefixer = require('autoprefixer');
var fileinclude = require('gulp-file-include');
var plugins = require("gulp-load-plugins")({
    lazy: false
});

const imagemin = require('gulp-imagemin');

gulp.task('img', () =>
    gulp.src('./src/img/*')
    .pipe(imagemin())
    .pipe(gulp.dest('./dist/img'))
);

gulp.task('vendorJS', function() {
    //concatenate vendor JS files
    gulp.src(['./bower_components/**/*.js','./bower_components/**/**/*.js'])
        //.pipe(plugins.jshint())
        //.pipe(plugins.jshint.reporter('default'))
        //.pipe(plugins.concat('lib.js'))
        .pipe(gulp.dest('./dist/bower_components'));
});
gulp.task('vendorCSS', function() {
    //concatenate vendor CSS files
    gulp.src(['!./bower_components/**/*.min.css',
            './bower_components/**/*.css'
        ])
        //.pipe(plugins.concat('lib.css'))
        .pipe(gulp.dest('./dist/bower_components'));
});
gulp.task('js', function() {
    gulp.src('./src/**/*.js')
        .pipe(plugins.jshint())
        .pipe(plugins.jshint.reporter('default'))
        .pipe(plugins.concat('main.js'))
        .pipe(gulp.dest('./dist/js'));
});
gulp.task('css', function() {
    gulp.src('./src/**/*.css')
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.postcss([autoprefixer({
            browsers: ['last 2 versions']
        })]))
        .pipe(plugins.sourcemaps.write('.'))
        .pipe(plugins.concat('style.css'))
        .pipe(gulp.dest('./dist/css'));
});
gulp.task('fonts', function() {
    gulp.src('./bower_components/**/fonts/*.*')
        .pipe(gulp.dest('./dist/bower_components'));
});
gulp.task('copy', function() {
    gulp.src(['./src/*.html', './src/*.php'])
        .pipe(fileinclude({
            prefix: '@@',
            basepath: '@file'
        }))
        .pipe(plugins.htmlmin({
            collapseWhitespace: true
        }))
        .pipe(gulp.dest('./dist'));
});
gulp.task('watch', function() {
    gulp.watch(['./src/**/*.js', '!./src/**/*test.js'], ['js']);
    gulp.watch('./src/**/*.css', ['css']);
    gulp.watch('./src/*.html', ['copy']);


});

gulp.task('default', ['copy', 'css', 'js', 'vendorCSS', 'vendorJS', 'img', 'fonts', 'watch'], function() {
    gulp.src('dist')
        .pipe(plugins.webserver({
            port: 9000,
            livereload: true
        }));
});
