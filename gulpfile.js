var gulp = require('gulp');
var babel = require('gulp-babel');
var concat = require('gulp-concat');
var replace = require('gulp-replace');

gulp.task('scripts', function() {
  return gulp.src(
    [
      'js-src/graphql.js',
      'js-src/liveticker.js'
    ])
    .pipe(concat('liveticker.js'))
    .pipe(babel({presets: ['@babel/env']}))
    .pipe(replace(/"use strict";/g, ''))
    .pipe(gulp.dest('resources/js/'));
});
