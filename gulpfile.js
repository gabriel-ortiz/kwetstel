// GULP PACKAGES
// Most packages are lazy loaded
var gulp        = require('gulp'),
	gutil       = require('gulp-util'),
	browserSync = require('browser-sync').create(),
	filter      = require('gulp-filter'),
	touch       = require('gulp-touch-cmd'),
	plugin      = require('gulp-load-plugins')(),
	concat      = require('gulp-concat'),
	csso        = require('gulp-csso');
	browserify  = require('browserify'),
	source      = require('vinyl-source-stream'),
	buffer      = require('vinyl-buffer'),
	log         = require('gulplog'),
	globby      = require('globby'),
	through     = require('through2'),
	uglify      = require('gulp-uglify'),
	ignore      = require('gulp-ignore');


// GULP VARIABLES
// Modify these variables to match your project needs

// Set local URL if using Browser-Sync
const LOCAL_URL = 'req.protocol+"://"+req.headers.host/';

// Set path to Foundation files
const FOUNDATION = 'node_modules/foundation-sites';

// Select Foundation components, remove components project will not use
const SOURCE = {
	vendorScripts: [
		// Lets grab what-input first
		'node_modules/what-input/dist/what-input.js',

		//include the waypoints library
		'node_modules/waypoints/lib/jquery.waypoints.min.js',

		//add fancybox JS
		'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js',

		//include Tweenmax library
		'node_modules/gsap/src/minified/TweenMax.min.js',

		// Foundation core - needed if you want to use any of the components below
		FOUNDATION + '/dist/js/plugins/foundation.core.js',
		FOUNDATION + '/dist/js/plugins/foundation.util.*.js',

		// Pick the components you need in your project
		FOUNDATION + '/dist/js/plugins/foundation.abide.js',
		FOUNDATION + '/dist/js/plugins/foundation.accordion.js',
		FOUNDATION + '/dist/js/plugins/foundation.accordionMenu.js',
		FOUNDATION + '/dist/js/plugins/foundation.drilldown.js',
		FOUNDATION + '/dist/js/plugins/foundation.dropdown.js',
		FOUNDATION + '/dist/js/plugins/foundation.dropdownMenu.js',
		FOUNDATION + '/dist/js/plugins/foundation.equalizer.js',
		FOUNDATION + '/dist/js/plugins/foundation.interchange.js',
		FOUNDATION + '/dist/js/plugins/foundation.offcanvas.js',
		FOUNDATION + '/dist/js/plugins/foundation.orbit.js',
		FOUNDATION + '/dist/js/plugins/foundation.responsiveMenu.js',
		FOUNDATION + '/dist/js/plugins/foundation.responsiveToggle.js',
		FOUNDATION + '/dist/js/plugins/foundation.reveal.js',
		FOUNDATION + '/dist/js/plugins/foundation.slider.js',
		FOUNDATION + '/dist/js/plugins/foundation.smoothScroll.js',
		FOUNDATION + '/dist/js/plugins/foundation.magellan.js',
		FOUNDATION + '/dist/js/plugins/foundation.sticky.js',
		FOUNDATION + '/dist/js/plugins/foundation.tabs.js',
		FOUNDATION + '/dist/js/plugins/foundation.responsiveAccordionTabs.js',
		FOUNDATION + '/dist/js/plugins/foundation.toggler.js',
		FOUNDATION + '/dist/js/plugins/foundation.tooltip.js',
	],

	// Place custom JS here, files will be concantonated, minified if ran with --production
	scripts: 'assets/scripts/js/**/*.js',

	//vendor css that can't be concatonated by SCSS
	vendor_css: [
		'node_modules/animate.css/animate.min.css',
		'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.css',
	],

	// Scss files will be concantonated, minified if ran with --production
	styles: 'assets/styles/scss/**/*.scss',

	// Images placed here will be optimized
	images: 'assets/images/src/**/*',

	php: '**/*.php'
};

const ASSETS = {
	styles: 'assets/styles/',
	scripts: 'assets/scripts/',
	images: 'assets/images/',
	all: 'assets/'
};

const JSHINT_CONFIG = {
	"node": true,
	"globals": {
		"document": true,
		"window": true,
		"jQuery": true,
		"$": true,
		"Foundation": true
	}
};

// GULP FUNCTIONS
// JSHint, concat, and minify JavaScript
gulp.task('scripts', function () {

	// gulp expects tasks to return a stream, so we create one here.
	var bundledStream = through();

	bundledStream
	// turns the output bundle stream into a stream containing
	// the normal attributes gulp plugins expect.
		.pipe(source('scripts.js'))
		// the rest of the gulp task, as you would normally write it.
		// here we're copying from the Browserify + Uglify2 recipe.
		.pipe(buffer())
		.pipe(plugin.sourcemaps.init({loadMaps: true}))
		// Add gulp plugins to the pipeline here.
		.pipe(ignore.exclude([ "**/*.map" ]))
		.pipe(uglify().on('error', gutil.log))
		.pipe(plugin.sourcemaps.write('./'))
		.pipe(gulp.dest(ASSETS.scripts))
		.pipe(touch());

	// "globby" replaces the normal "gulp.src" as Browserify
	// creates it's own readable stream.
	globby( SOURCE.scripts ).then(function(entries) {
		// create the Browserify instance.
		var b = browserify({
			entries: entries,
			debug: true

		})
			.transform('babelify',
				{
					presets: ["@babel/preset-env"],
					"ignore": [
						"/node_modules/"
					]
				});

		// pipe the Browserify stream into the stream we created earlier
		// this starts our gulp pipeline.
		b.bundle().pipe(bundledStream);
	}).catch(function(err) {
		// ensure any errors from globby are handled
		bundledStream.emit('error', err);
	});

	// finally, we return the stream, so gulp knows when this task is done.
	return bundledStream;


});

gulp.task('vendorScripts', function() {


	return gulp.src( SOURCE.vendorScripts )
		.pipe(plugin.plumber(function(error) {
			gutil.log(gutil.colors.red(error.message));
			this.emit('end');
		}))
		.pipe(plugin.sourcemaps.init())
		.pipe(plugin.babel({
			presets: ['es2015'],
			compact: true,
			ignore: ['what-input.js']
		}))
		.pipe(plugin.concat('vendor-scripts.js'))
		.pipe(plugin.uglify())
		.pipe(plugin.sourcemaps.write('.')) // Creates sourcemap for minified JS
		.pipe(gulp.dest(ASSETS.scripts))
		.pipe(touch());
});

// Compile Sass, Autoprefix and minify
gulp.task('styles', function () {

	return gulp.src(SOURCE.styles)
		.pipe(plugin.plumber(function(error) {
			gutil.log(gutil.colors.red(error.message));
			this.emit('end');
		}))
		.pipe(plugin.sourcemaps.init())
		.pipe(plugin.sass())
		.pipe(plugin.autoprefixer({
			browsers: [
				'last 2 versions',
				'ie >= 9',
				'ios >= 7'
			],
			cascade: false
		}))
		.pipe(csso({
			restructure: false,
		}))
		.pipe(plugin.sourcemaps.write('.'))
		.pipe(gulp.dest(ASSETS.styles))
		.pipe(touch());
});


// Optimize images, move into assets directory
gulp.task('images', function () {
	return gulp.src(SOURCE.images)
		.pipe(plugin.imagemin())
		.pipe(gulp.dest(ASSETS.images))
		.pipe(touch());
});

gulp.task('translate', function () {
	return gulp.src(SOURCE.php)
		.pipe(plugin.wpPot({
			domain: 'jointswp',
			package: 'Example project'
		}))
		.pipe(gulp.dest('file.pot'));
});

// Browser-Sync watch files and inject changes
gulp.task('browsersync', function () {

	// Watch these files
	var files = [
		SOURCE.php,
	];

	browserSync.init(files, {
		proxy: LOCAL_URL,
	});

	gulp.watch(SOURCE.styles, gulp.parallel('styles')).on('change', browserSync.reload);
	gulp.watch(SOURCE.scripts, gulp.parallel('scripts')).on('change', browserSync.reload);
	gulp.watch(SOURCE.vendorScripts, gulp.parallel('vendorScripts')).on('change', browserSync.reload);
	gulp.watch(SOURCE.images, gulp.parallel('images')).on('change', browserSync.reload);

});

// Watch files for changes (without Browser-Sync)
gulp.task('watch', function () {

	// Watch .scss files
	gulp.watch(SOURCE.styles, gulp.parallel('styles'));

	// Watch scripts files
	gulp.watch(SOURCE.scripts, gulp.parallel('scripts'));

	// Watch scripts files
	//gulp.watch(SOURCE.vendorScripts, gulp.parallel('vendorScripts'));

	// Watch images files
	gulp.watch(SOURCE.images, gulp.parallel('images'));

});

// Run styles, scripts and foundation-js
gulp.task('default', gulp.parallel('styles', 'scripts', 'images', 'vendorScripts') );