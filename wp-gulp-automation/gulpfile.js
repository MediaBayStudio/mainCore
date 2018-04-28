"use strict";

var gulp = require("gulp");
var less = require("gulp-less");
var plumber = require("gulp-plumber");
var postcss = require("gulp-postcss");
var autoprefixer = require("autoprefixer");
var minify = require("gulp-csso");
var server = require("browser-sync").create();
var connectPHP = require('gulp-connect-php');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var run = require("run-sequence");
var rename = require("gulp-rename")
var uglify = require('gulp-uglify');

gulp.task("style", function() {
  gulp.src("../less/style.less")
    .pipe(plumber())
    .pipe(less())
    .pipe(postcss([
      autoprefixer()
    ]))
    .pipe(gulp.dest("../"))
    .pipe(minify())
    .pipe(rename("style.min.css"))
    .pipe(gulp.dest("../"))
    .pipe(server.stream());
});

gulp.task('js', function () {
  gulp.src('../js/src/*.js')
  .pipe(concat('main.js'))
  .pipe(gulp.dest('../js'))

  .pipe(uglify())
  .pipe(rename("main.min.js"))
  .pipe(gulp.dest("../js"))
  .pipe(server.stream());
});


gulp.task('php', function(){
  connectPHP.server({ base: './site.dev', keepalive:true, hostname: 'localhost', port:8080, open: false});
});

gulp.task("build", function(done) {
  run(
    "style",
    "js",
    "serve",
    done
  );
});

gulp.task("serve", function() {
  server.init({
    proxy:'127.0.0.1',
    port:8080
  });

  gulp.watch("../less/**/*.less", ["style"]);
  gulp.watch("../*.php").on("change", server.reload);

});