const gulp = require('gulp');
const del = require('del');

const babel = require('gulp-babel');
const uglify = require('gulp-uglify');

const stylus = require('gulp-stylus');
const autoprefixer = require('gulp-autoprefixer');
const cleanCss = require('gulp-clean-css');

const paths = {
	src: './userSystem/src/',
	bulid: './userSystem/bulid/'
}

function clean(cb){
	del([paths.bulid]);
	cb();
}

function bulid__HTML(cb){
	gulp.src(paths.src.concat('*.{html,php}'))
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

const bulidUserSystem = gulp.series(clean, bulid__HTML, bulid__JS, bulid__Css);

gulp.task('bulid', bulidUserSystem);
gulp.task('clean', gulp.series(clean));

exports.bulid = bulidUserSystem;
exports.clean = gulp.series(clean);