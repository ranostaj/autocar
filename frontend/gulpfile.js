var gulp = require('gulp');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var minifyCss = require('gulp-minify-css');
var rename = require('gulp-rename');


gulp.task('sass', function() {
    return gulp.src('sass/*.scss')
        .pipe(sass({
            errLogToConsole: true
        }))
        .pipe(gulp.dest('webroot/css'))
});

gulp.task('css',function(){
    return gulp.src('webroot/css/main.css')
        .pipe(concat('main.css'))
        .pipe(minifyCss())
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest('webroot/css'));
});

gulp.task('watch', function() {
    gulp.watch('sass/**/*.scss', ['sass']);
})
