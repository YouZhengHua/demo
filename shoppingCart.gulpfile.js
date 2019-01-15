const gulp = require('gulp');
const del = require('del');

const babel = require('gulp-babel');
const uglify = require('gulp-uglify');

const paths = {
	src: './shoppingCart/src/',
	bulid: './shoppingCart/bulid/'
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

const bulidShoppingCart = gulp.series(clean, bulid__HTML, bulid__JS);

gulp.task('bulid', bulidShoppingCart);

exports.bulid = bulidShoppingCart;
exports.clean = gulp.series(clean);