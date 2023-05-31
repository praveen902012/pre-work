var gulp = require('gulp');
var watch = require('gulp-watch');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var gulpif = require('gulp-if');
var minimist = require('minimist');
var util = require('gulp-util');
var randomstring = require("randomstring");

var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');

var browserify = require('browserify');

var fs = require('fs');
var path = require('path');
var jshint = require('gulp-jshint');
var stylish = require('jshint-stylish');

var recursiveReadSync = require('recursive-readdir-sync')

var redlofJSFiles = require('./resources/assets/js/redlof.json');

var knownOptions = {
    string: 'env',
    default: {
        env: 'dev'
    }
};

var options = minimist(process.argv.slice(2), knownOptions);

// SCSS Css
var cssDir = ['Redlof/sass/app.scss'];
var cssAdmin = ['Redlof/sass/admin.scss'];
var cssVendorDir = ['resources/assets/sass/vendor.scss'];

gulp.task('css', function() {
    return gulp.src(cssDir, {
            'style': 'compressed'
        })
        .pipe(postcss([autoprefixer({
            browsers: ['last 10 versions']
        })]))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('css-admin', function() {
    return gulp.src(cssAdmin, {
            'style': 'compressed'
        })
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer({
            browsers: ['last 10 versions']
        })]))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('css-vendor', function() {
    return gulp.src(cssVendorDir, {
            'style': 'compressed'
        })
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('js', function() {


    var Modules = require('./Redlof/angular/app.json');


    for (var i = 0; i < Modules.length; i++) {

        var ModuleJS = Modules[i][1];
        var ModuleUglify = Modules[i][2];

        var ModuleJSFiles = getModuleFiles(Modules[i]);

        gulp.src(ModuleJSFiles)
            .pipe(jshint())
            .pipe(jshint.reporter(stylish))
            .pipe(concat(ModuleJS))
            .pipe(gulpif(ModuleUglify === 'uglify', uglify()))
            .pipe(gulp.dest('./public/js'));
    }
});


gulp.task('js-vendor', function() {

    browserify("./resources/assets/js/vendor.js")
        .bundle()
        .on("error", function(e) {
            util.log(e);
        })
        .pipe(source("vendor.js"))
        .pipe(buffer())
        .pipe(uglify())
        .pipe(gulp.dest("./public/js"));


});

gulp.task('js-redlof', function() {
    redlofList = processPath('resources/assets/js/', redlofJSFiles);

    gulp.src(redlofList)
        .pipe(jshint())
        .pipe(jshint.reporter(stylish))
        .pipe(concat('redlof.js'))
        //.pipe(uglify())
        .pipe(gulp.dest('./public/js'));
});

gulp.task('watch', function() {
    gulp.watch('Redlof/sass/**/*.scss', ['css']);
    gulp.watch('Redlof/sass/**/*.scss', ['css-admin']);
    gulp.watch('Redlof/angular/**/*.js', ['js']);
    gulp.watch('resources/assets/js/redlof/**/*.js', ['js-redlof']);
    //gulp.watch('resources/assets/js/vendor.js', ['js-vendor']);
});

gulp.task('default', ['css', 'css-admin', 'css-vendor', 'js', 'js-vendor', 'js-redlof']);


function getCoreFileList() {

    var CorePath = './Redlof/angular/Core';
    var files = recursiveReadSync(CorePath);

    return files.reverse();
}


function getFolders(dir) {
    return fs.readdirSync(dir)
        .filter(function(file) {
            return fs.statSync(path.join(dir, file)).isDirectory();
        });
}


function getModuleFiles(Module) {

    var ModulePath = './Redlof/angular/' + Module[0];

    // get all the foldes
    var folders = getFolders(ModulePath);

    var ModuleFileList = [];


    ModuleFileList.push(ModulePath + '/' + Module[1]);
    ModuleFileList.push(ModulePath + '/run.js');
    ModuleFileList.push(ModulePath + '/start.js');

    ModuleFileList = ModuleFileList.concat(getCoreFileList());

    for (var i = 0; i < folders.length; i++) {
        var Folder = path.join(ModulePath, folders[i]);
        var files = recursiveReadSync(Folder);
        ModuleFileList = ModuleFileList.concat(files.reverse());
    }

    return ModuleFileList;
}

function processPath(path, rawdata) {
    var ProcessedData = [];
    for (i = 0; i < rawdata.length; i++) {
        ProcessedData.push(path + rawdata[i]);
    }
    return ProcessedData;
}

gulp.task('production', function() {

    // Call each of the tasks
    // Wait for them to finish

    // Create build.json
    // Create the random string for the unique
    // add the files

    var randomKey = randomstring.generate(10);
    var buildJsonContents = {};

    var jsFiles = recursiveReadSync('public/js');
    var cssFiles = recursiveReadSync('public/css');

    jsFiles = jsFiles.concat(cssFiles);

    for (var i = 0; i < jsFiles.length; i++) {

        var fileName = path.basename(jsFiles[i]);

        var fileKey = jsFiles[i].substr(7)

        buildJsonContents[fileKey] = fileName + "?id=" + randomKey;

        fs.copyFileSync(jsFiles[i], 'public/build/' + fileName);
    }


    buildJsonContents = JSON.stringify(buildJsonContents);

    fs.writeFile('public/build/build.json', buildJsonContents, 'utf8', function() {
        console.log("We can push to production now !!")
    });

});