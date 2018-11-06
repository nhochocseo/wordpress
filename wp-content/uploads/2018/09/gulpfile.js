var gulp = require('gulp'),
    scss = require('gulp-sass');

gulp.task('scss-global', function () {
    return gulp.src(['assets/sass/**/*.scss'])
        .pipe(scss())
        .pipe(gulp.dest('assets/css'))
});

gulp.task('scss-shortcode', function () {
    return gulp.src(['inc/shortcodes/**/**/assets/sass/*.scss'])
        .pipe(scss())
        .pipe(gulp.dest('inc/shortcodes/**/**/assets/css'))
});

gulp.task('watch', function () {
    gulp.watch(['assets/sass/**/*.scss'], ['scss-global']);
    gulp.watch(['inc/shortcodes/**/**/assets/sass/*.scss'], ['scss-shortcode']);
});