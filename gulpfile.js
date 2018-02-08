var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    cleanCSS = require('gulp-clean-css');;


var jsDest = 'www/assetts/js',
    cssDest = 'www/assetts/css';

gulp.task('default', defaultTask);

function defaultTask(done) {

 /********************/
 /* Copy Stylesheets */
 /********************/

 // Bootstrap
 gulp.src(['node_modules/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css', 'node_modules/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css.map'])
  .pipe(gulp.dest(cssDest));

// Font awesome
 gulp.src('node_modules/gentelella/vendors/font-awesome/css/font-awesome.min.css')
  .pipe(gulp.dest(cssDest));

 // Gentelella
 gulp.src('node_modules/gentelella/build/css/custom.min.css')
  .pipe(rename('gentelella.min.css'))
  .pipe(gulp.dest(cssDest));

/****************/
/* Copy Scripts */
/****************/


// Bootstrap
gulp.src('node_modules/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js')
  .pipe(gulp.dest(jsDest));

// jQuery
gulp.src('node_modules/gentelella/vendors/jquery/dist/jquery.min.js')
  .pipe(gulp.dest(jsDest));

// Gentelella
gulp.src('node_modules/gentelella/build/js/custom.min.js')
   .pipe(rename('gentelella.min.js'))
  .pipe(gulp.dest(jsDest));


 /**************/
 /* Copy Fonts */
 /**************/

// Bootstrap
gulp.src('node_modules/gentelella/vendors/bootstrap/fonts/*')
  .pipe(gulp.dest('www/assetts/fonts'));

// Font awesome
gulp.src('node_modules/gentelella/vendors/font-awesome/fonts/*')
  .pipe(gulp.dest('www/assetts/fonts'));


 /*********************/
 /* Bootstrap plugins */
 /*********************/

var pluginsFilesJS = [
            'node_modules/gentelella/vendors/fastclick/lib/fastclick.js',
            'node_modules/gentelella/vendors/nprogress/nprogress.js',
            'node_modules/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
            'node_modules/gentelella/vendors/iCheck/icheck.min.js',

            'node_modules/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js',
            'node_modules/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
            'node_modules/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js',
            'node_modules/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js',
            'node_modules/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js',
            'node_modules/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js',
            'node_modules/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js',
            'node_modules/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js',
            'node_modules/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js',
            'node_modules/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js',
            'node_modules/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js',
            'node_modules/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js'
            
            ];


gulp.src(pluginsFilesJS)
    .pipe(concat('bootstrap-plugins.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(jsDest));

var pluginsFilesCSS = [
            'node_modules/gentelella/vendors/nprogress/nprogress.css',
            'node_modules/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
            'node_modules/gentelella/vendors/iCheck/skins/flat/green.css',

            'node_modules/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
            'node_modules/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css',
            'node_modules/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css',
            'node_modules/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css',
            'node_modules/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css'
            ];


gulp.src(pluginsFilesCSS)
    .pipe(concat('bootstrap-plugins.min.css'))
    .pipe(cleanCSS())
    .pipe(gulp.dest(cssDest));
 

var pluginsFilesIMG = [
            'node_modules/gentelella/vendors/iCheck/skins/flat/green.png'
            ];


gulp.src(pluginsFilesIMG)
    .pipe(gulp.dest(cssDest));


  done();



}