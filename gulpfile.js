// Load Gulp...of course
var gulp = require('gulp');

// CSS related plugins
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

// JS related plugins
var uglify = require('gulp-uglify');
var babelify = require('babelify');
var browserify = require('browserify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var stripDebug = require('gulp-strip-debug');

// Utility plugins
var rename = require('gulp-rename');
var sourcemaps = require('gulp-sourcemaps');
var notify = require('gulp-notify');
var options = require('gulp-options');
var gulpif = require('gulp-if');
var image = require('gulp-image');

var devDir = './';
var baseDir = '../../wp-content/themes/orchardrecovery/';

// Style Sheets
var styleSRC = devDir + 'src/scss/style.scss';
var styleDEST = baseDir;

// Javascript
var jsSRC = devDir + 'src/js/';
var jsParallax = 'disableparallax.js';
var jsGeneral = 'general.js';
var jsFiles = [jsParallax, jsGeneral];
var jsDEST = baseDir + 'dist/js/';

// Images
var screenshotSRC = devDir + 'src/images/screenshot.png';
var screenshotURL = baseDir;

// Index files watch
var srcIndexWatch = devDir + 'src/index.php';
var srcJSIndexWatch = devDir + 'src/js/index.php';
var jsWatch = devDir + 'src/js/**/*.js';
var fontsWatch = devDir + 'src/fonts/*.*';

var pluginsWatch = devDir + 'plugins/**/*.php';
var rootFiles = ['LICENSE', 'README.md', '*.php'];

function style(done) {
    gulp
        .src(styleSRC)
        //        .pipe(sourcemaps.init())   // Initialize sourcemaps before compilation starts
        .pipe(sass({
            errLogToConsole: true,
            outputStyle: 'compressed'
        }))
        .on("error", sass.logError)
        .pipe(autoprefixer({ overrideBrowserslist: ['last 2 versions', '> 5%', 'Firefox ESR', 'not dead'] }))
        //        .pipe(rename({ suffix: '.min' }))
        //        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(styleDEST));
    done();
}

function script(done) {
    jsFiles.map(function (entry) {
        return browserify({
            entries: [jsSRC + entry]
        })
            .transform(babelify, { presets: ['@babel/preset-env'] })
            .bundle()
            .pipe(source(entry))
            .pipe(buffer())
            .pipe(gulpif(options.has('production'), stripDebug()))
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(uglify())
            .pipe(rename({ suffix: '.min' }))
            .pipe(sourcemaps.write('./'))
            .pipe(gulp.dest(jsDEST))
    });
    done();
}

function compressScreenshot(done) {
    gulp.src(screenshotSRC)
        .pipe(image())
        .pipe(gulp.dest(screenshotURL));
    done();
}

function copySrcIndex(done) {
    gulp.src(srcIndexWatch, { allowEmpty: true })
        .pipe(gulp.dest(baseDir + './dist/'));
    done();
}

function copySrcJSIndex(done) {
    gulp.src(srcJSIndexWatch, { allowEmpty: true })
        .pipe(gulp.dest(baseDir + './dist/js'));
    done();
}

function copyFonts(done) {
    gulp.src(fontsWatch, { allowEmpty: true })
        .pipe(gulp.dest(baseDir + './dist/fonts'));
    done();
}

function copyRootFiles(done) {
    gulp.src(rootFiles, { allowEmpty: true })
        .pipe(gulp.dest(baseDir));
    done();
}

function copyPlugins(done) {
    gulp.src(pluginsWatch, { allowEmpty: true })
        .pipe(gulp.dest(baseDir + './plugins'));
    done();
}

function watchFiles() {
    gulp.watch(styleSRC, style);
    gulp.watch(jsWatch, script);
    gulp.watch(srcIndexWatch, copySrcIndex);
    gulp.watch(srcJSIndexWatch, copySrcJSIndex);
    gulp.watch(fontsWatch, copyFonts);
    gulp.watch(rootFiles, copyRootFiles);
    gulp.watch(pluginsWatch, copyPlugins);
    gulp.watch(screenshotSRC, compressScreenshot);
    gulp.src(styleSRC).pipe(notify({ message: 'Gulp is Watching, Happy Coding!' }));
}

var watch = gulp.parallel(style, script, copySrcIndex, copySrcJSIndex, copyFonts, copyRootFiles, copyPlugins, compressScreenshot, watchFiles);

exports.style = style;
exports.script = script;
exports.watch = watch;
exports.default = watch;
