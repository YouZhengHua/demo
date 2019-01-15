const gulp = require('gulp');
const del = require('del');

const babel = require('gulp-babel');
const uglify = require('gulp-uglify');

const stylus = require('gulp-stylus');
const autoprefixer = require('gulp-autoprefixer');
const cleanCss = require('gulp-clean-css');

const todoList = require('./todoList.gulpfile');
const userSystem = require('./userSystem.gulpfile');
const twitchApi = require('./twitchApi.gulpfile');
const shoppingCart = require('./shoppingCart.gulpfile');

gulp.task('cleanAll', gulp.series(todoList.clean, userSystem.clean, twitchApi.clean, shoppingCart.clean));

gulp.task('bulidAll', gulp.series(todoList.bulid, userSystem.bulid, twitchApi.bulid, shoppingCart.bulid));