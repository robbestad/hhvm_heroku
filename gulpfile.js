var gulp = require('gulp');
var webserver = require('gulp-webserver');
var concat = require('gulp-concat');
var scss = require('gulp-sass');
var less = require('gulp-less');
var uglify = require('gulp-uglify');
var prettify = require('gulp-prettify');
var cssmin = require('gulp-cssmin');
var autoprefixer = require('gulp-autoprefixer');
var imagemin = require('gulp-imagemin');
var del = require('del');
//var sourcemaps = require('gulp-sourcemaps');
var notify = require("gulp-notify");
var pngcrush = require('imagemin-pngcrush');
var react = require('gulp-react');
var git = require('gulp-git');
var shell = require('gulp-shell');

var paths = {
    scripts: 'dev/js/**/*',
    jslibs: [
        'bower_components/jquery/dist/jquery.min.js',
        'bower_components/react/react.min.js',
        'bower_components/bootstrap/js/**/*'
    ],
    images: 'dev/img/**/*',
    jsx: 'dev/jsx/**/*',
    phpscripts: 'dev/**/*.php',
    less: 'bower_components/bootstrap/less/bootstrap.less',
    fonts: ['dev/fonts/**/*', 'bower_components/font-awesome/fonts/**/*', 
    'bower_components/bootstrap/fonts/**/*'],
    scss: ['bower_components/font-awesome/scss/font-awesome.scss',
        'dev/scss/main.scss'
    ]
};

gulp.task('jsx', function () {
    return gulp.src(paths.jsx)
        .pipe(react())
        .pipe(gulp.dest('dev/js'));
});



gulp.task('clean', function (cb) {
    // You can use multiple globbing patterns as you would with `gulp.src`
    del(['build','dist/pages','dist/css','dist/**/*.html','dist/**/*.php',
        'dist/img/**/*','dist/**/*.hhvm','dist/js/**/*'], cb);
});



gulp.task('htaccess', function () {
    return gulp.src('dev/.htaccess')
        .pipe(gulp.dest('dist'));
});


gulp.task('phpscripts', function () {
    return gulp.src(paths.phpscripts)
        .pipe(gulp.dest('dist'))
        .pipe(gulp.dest('build'));
});


gulp.task('fonts', function () {
    return gulp.src(paths.fonts)
        .pipe(gulp.dest('dist/fonts'))
        .pipe(gulp.dest('build/fonts'));
});


gulp.task('language', function () {
    return gulp.src('dev/language')
        .pipe(gulp.dest('dist'));
});


gulp.task('sass', function () {
    return gulp.src(paths.scss)
        .pipe(scss())
        .pipe(autoprefixer())
        .pipe(cssmin())
        .pipe(gulp.dest('dev/css'));
});

gulp.task('less', function () {
    return gulp.src(paths.less)
        .pipe(less())
        .pipe(autoprefixer())
        .pipe(cssmin())
        .pipe(gulp.dest('dev/css'));
});

gulp.task('csscat', ['less', 'sass'], function () {
    return gulp.src(['dev/css/bootstrap.css', 
            'dev/css/font-awesome.css',
//            'dev/css/cantarell.css',
//            'dev/css/roboto.css',
            'dev/css/main.css'])
        .pipe(concat('style.min.css'))
        .pipe(gulp.dest('dist/css'))
        .pipe(gulp.dest('build/css'));
});


// Render all the JavaScript files
gulp.task('javascript', ['jsx'], function () {
    return gulp.src(paths.scripts)
        .pipe(uglify({'mangle': false}))
        .pipe(concat('scripts.min.js'))
        .pipe(gulp.dest('dist/js'))
        .pipe(gulp.dest('build/js'));
});

// Copy all static libraries
gulp.task('jslibs', function () {
    return gulp.src(paths.jslibs)
        .pipe(concat('libs.min.js'))
        .pipe(gulp.dest('dist/js'))
        .pipe(gulp.dest('build/js'));
});

// Run git add
// src is the file(s) to add (or ./*)
gulp.task('git-add', function(){
    return gulp.src('./dev/*')
        .pipe(git.add());
});

// Run git commit
// src are the files to commit (or ./*)
gulp.task('git-commit', ['git-add'], function(){
    return gulp.src('.')
        .pipe(git.commit('auto-commit'));
});

// Copy all static images
gulp.task('images', function () {
    return gulp.src(paths.images)
        // Pass in options to the task
        .pipe(imagemin({
            optimizationLevel: 5,
            progressive: true,
            svgoPlugins: [
                {removeViewBox: false}
            ],
       //     use: [pngcrush()]
        }))
        .pipe(gulp.dest('dist/img'))
        .pipe(gulp.dest('build/img'));
});

gulp.task('heroku', shell.task([
//    'git add .',
    'git commit -am"autocommit" --allow-empty',
    'git push',
    'git push heroku master '
]));

// Execute the built-in webserver
gulp.task('webserver', function () {
    gulp.src('dist')
        .pipe(webserver({
            livereload: true,
            path: 'dist',
            port: '8085',
            directoryListing: false,
            open: true
        }));
});

// Rerun the task when a file changes
gulp.task('watch', function () {
    gulp.watch(paths.scripts, ['javascript']);
    gulp.watch(paths.jsx, ['javascript']);
    gulp.watch('dev/.htaccess', ['htaccess']);
    gulp.watch('dev/scss/**/*', ['csscat']);
    gulp.watch(paths.phpscripts, ['phpscripts']);
    gulp.watch(paths.images, ['images']);
});

// gulp main tasks
gulp.task('default', ['watch', 'htaccess', 'csscat', 
	'fonts', 'javascript', 'images', 'jslibs', 
	'jsx', 'language', 'phpscripts']);
gulp.task('serve', ['default', 'webserver']);
gulp.task('git', ['default', 'heroku']);