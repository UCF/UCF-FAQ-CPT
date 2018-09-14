const gulp         = require('gulp');
const browserSync  = require('browser-sync').create();
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS     = require('gulp-clean-css');
const include      = require('gulp-include');
const readme       = require('gulp-readme-to-markdown');
const rename       = require('gulp-rename');
const sass         = require('gulp-sass');
const sassLint     = require('gulp-sass-lint');

let config = {
  src: {
    scssPath: './src/scss',
  },
  dist: {
    cssPath: './static/css',
  },
  packagesPath: './node_modules',
};

//
// Helper functions
//

// BrowserSync reload function
function serverReload(done) {
  if (config.sync) {
    browserSync.reload();
  }
  done();
}

// BrowserSync serve function
function serverServe(done) {
  if (config.sync) {
    browserSync.init({
      proxy: {
        target: config.syncTarget
      }
    });
  }
  done();
}

// Base SCSS linting function
function lintSCSS(src) {
  return gulp.src(src)
    .pipe(sassLint())
    .pipe(sassLint.failOnError());
}

// Base SCSS compile function
function buildCSS(src, dest) {
  dest = dest || config.dist.cssPath;

  return gulp.src(src)
    .pipe(sass({
      includePaths: [config.src.scssPath, config.packagesPath]
    })
      .on('error', sass.logError))
    .pipe(cleanCSS())
    .pipe(autoprefixer({
      // Supported browsers added in package.json ("browserslist")
      cascade: false
    }))
    .pipe(rename({
      extname: '.min.css'
    }))
    .pipe(gulp.dest(dest));
}

//
// CSS
//

// Lint all plugin scss files
gulp.task('scss-lint-plugin', () => {
  return lintSCSS(`${config.src.scssPath}/*.scss`);
});

// Compile plugin stylesheet
gulp.task('scss-build-plugin', () => {
  return buildCSS(`${config.src.scssPath}/ucf-faq.scss`);
});

// All plugin css-related tasks
gulp.task('css', gulp.series('scss-lint-plugin', 'scss-build-plugin'));


//
// Documentation
//

// Generates a README.md from README.txt
gulp.task('readme', () => {
  return gulp.src('readme.txt')
    .pipe(readme({
      details: false,
      screenshot_ext: [] // eslint-disable-line camelcase
    }))
    .pipe(gulp.dest('.'));
});


//
// Rerun tasks when files change
//
gulp.task('watch', (done) => {
  serverServe(done);

  gulp.watch(`${config.src.scssPath}/**/*.scss`, gulp.series('css', serverReload));
  gulp.watch('./**/*.php', gulp.series(serverReload));
});


//
// Default task
//
gulp.task('default', gulp.series('css', 'readme'));
