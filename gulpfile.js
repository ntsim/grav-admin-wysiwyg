const gulp = require('gulp');
const sass = require('gulp-sass');
const babel = require('gulp-babel');


gulp.task('scripts', () => {
    return gulp.src('./js/*.js')
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(gulp.dest('./js-compiled'));
});

gulp.task('styles', () => {
     return gulp.src('./scss/*.scss')
         .pipe(sass({ includePaths: [] }).on('error', sass.logError))
         .pipe(gulp.dest('./css-compiled'));
});

gulp.task('build', ['scripts', 'styles']);

gulp.task('watch', () => {
    gulp.watch(['./js/*.js'], ['scripts']);
    gulp.watch(['./scss/*.scss'], ['styles']);
});

gulp.task('default', ['build']);
