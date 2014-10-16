// npm install gulp-autoprefixer gulp-minify-css gulp-jshint gulp-concat gulp-uglify gulp-imagemin gulp-notify --save-dev


var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var minifyCSS = require('gulp-minify-css'); // Minify CSS
var notify = require('gulp-notify'); // Terminal Messages
var uglify = require('gulp-uglify'); // Minify JS
var concat = require('gulp-concat'); // Concat src files in to one file
var imagemin = require('gulp-imagemin'); // Compresses images
var pngcrush = require('imagemin-pngcrush'); // Min .png files
var jpegtran = require('imagemin-jpegtran'); // Min .jpg files

gulp.task('watch', function() {
    gulp.watch('assets/sass/**/*.scss', ['sass']);
    gulp.watch('assets/js/**/*.js', ['js']);
    gulp.watch('assets/images/*', ['images']);
});

gulp.task('sass', function() {
  return gulp.src('assets/sass/style.scss')
    .pipe(sass({ style: 'expanded' }))
    .pipe(gulp.dest('public/css'))
    .pipe(minifyCSS())
    .pipe(gulp.dest('public/css'))
    .pipe(notify({ message: 'Styles task complete' }));
});

gulp.task('js', function() {
    return gulp.src('assets/js/*.js')
    .pipe(concat('script.js'))
    .pipe(uglify())
    .pipe(gulp.dest('public/js'))
    .pipe(notify('JS - Compressed'));
});

gulp.task('images', function() {
    return gulp.src('assets/images/*')
    .pipe(imagemin({
        progressive: true,
        svgoPlugins: [{removeViewBox: false}],
        use: [pngcrush()]
    }))
    .pipe(imagemin({
        progressive: true,
        use: [jpegtran()]
    }))
    .pipe(gulp.dest('public/images/'));
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['watch', 'sass', 'js', 'images']);
