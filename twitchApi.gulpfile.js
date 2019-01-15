const gulp = require('gulp');
const del = require('del');

const babel = require('gulp-babel');
const uglify = require('gulp-uglify');

const stylus = require('gulp-stylus');
const autoprefixer = require('gulp-autoprefixer');
const cleanCss = require('gulp-clean-css');

const paths = {
	src: './twitchApi/src/',
	bulid: './twitchApi/bulid/'
}

function clean(cb){
	del([paths.bulid]);
	cb();
}

function bulid__HTML(cb){
	gulp.src(paths.src.concat('*.html'))
		.pipe(gulp.dest(paths.bulid));
	cb();
};

function bulid__JS(cb){
	gulp.src(paths.src.concat('js/*.js'))
		.pipe(babel({
			presets: ['@babel/env']
		}))
		.pipe(uglify())
		.pipe(gulp.dest(paths.bulid.concat('js/')));
	cb();
};

function bulid__Css(cb){
	gulp.src(paths.src.concat('css/*.styl'))
		.pipe(stylus())
		.pipe(autoprefixer({
			browsers: ['last 2 versions'],
            cascade: false
		}))
		.pipe(cleanCss())
		.pipe(gulp.dest(paths.bulid.concat('css/')))
	cb();
}

function bulid__img(cb){
	gulp.src(paths.src.concat('*.jpg'))
		.pipe(gulp.dest(paths.bulid.concat('css/')))
	cb();
}

const bulidTwitchApi = gulp.series(clean, bulid__HTML, bulid__JS, bulid__Css, bulid__img);

gulp.task('bulid', bulidTwitchApi);

exports.bulid = bulidTwitchApi;
exports.clean = gulp.series(clean);