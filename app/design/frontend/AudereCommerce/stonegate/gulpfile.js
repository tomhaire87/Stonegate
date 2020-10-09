var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var babel = require('gulp-babel');
var autoprefixer = require('gulp-autoprefixer');
var cleanCSS = require('gulp-clean-css');

function defaultTask(cb) {
    return gulp.src('./web/css/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(cleanCSS())
        .pipe(gulp.dest('./web/css'));
}

gulp.task('sass:watch', function() {
    gulp.watch('./web/css/**/**/*.scss', gulp.series(defaultTask));
});

exports.default = defaultTask;