module.exports = function (grunt) {
    'use strict';
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);
    // require('time-grunt')(grunt);

    grunt.initConfig({
        /* =======================================================================
          Set Client Name variable to be used throughout task 
        ========================================================================== */
        clientName: '_paperTheme(production)',
        /* ======================================================================= */
                   

        pkg: grunt.file.readJSON('package.json'),
        // compile sass to css 
        compass: {
            dev: {
                options: {
                    sassDir: 'scss',
                    cssDir: 'css',
                    require:'susy',
                    sourcemap: true
                }
            },
            // remove comments for production
            prod: {
                options: {
                    sassDir: 'scss',
                    cssDir: 'css',
                    outputStyle: 'compact',
                    noLineComments: true,
                    sourcemap: true
                }
            }
        },

        // add browser prefixes to compiled css
        autoprefixer: {
          options: {
            browsers: ['last 1 version','ie 8', 'ie 9']
          },
          dev: {
            files: [{
              expand: true,
              cwd: 'css/',
              src: '*.css',
              dest: 'css/'
            }]
          }
        },


        // concatenate css and js files (except ie.css and modernizr.custom.js, which need to remain separate)
        // output concatenated files to .tmp/assets
        concat: {
            css: {
                src: [
                    'css/*',
                    '!css/ie.css',
                    '!css/fonts/**',
                    '!css/admin.css',
                    '!css/login.css'
                ],
                dest: '.tmp/assets/css/style.css'
            },
            js: {
                src: [
                    'js/**/*.js',
                    '!js/libs/modernizr.custom.js'
                ],
                dest: '.tmp/assets/js/<%= clientName %>.min.js'
            }
        },

        // minify concatenated css in .tmp/
        cssmin: {
            css: {
              src: '.tmp/assets/css/style.css',
              dest: '.tmp/assets/css/style.min.css'
            },
            ie:{
              src: 'css/ie.css',
              dest: '.tmp/assets/css/ie.min.css'
            },
            login:{
              src: 'css/login.css',
              dest: '.tmp/assets/css/login.min.css'
            },
            admin:{
              src: 'css/admin.css',
              dest: '.tmp/assets/css/admin.min.css'
            }
        },

        copy: {
          prod_php: { 
            files: [{
                expand: true, 
                cwd:'./',
                src: ['**/**.php','style.css','layouts/*'], 
                dest: '../<%= clientName %>', 
                filter: 'isFile'
            }]
          },
          bower_comp:{
            files: [{
                expand: true, 
                cwd:'./',
                src: ['bower_components/**/**'], 
                dest: '../<%= clientName %>/', 
                filter: 'isFile'
            }]
          },
          fonts: {
              files: [{
                expand: true, 
                src: ['css/fonts/**/*'], 
                dest: '.tmp/assets', 
                filter: 'isFile'
              }]
          },
          prod_assets:{
            files: [{
                expand: true, 
                cwd:'./.tmp',
                src: ['**/**'], 
                dest: '../<%= clientName %>/', 
                filter: 'isFile'
            }]
          }
        },
        // compress images
        // output to .tmp/assets/imgs
        imagemin: {                          
          dynamic: {                         
            files: [{
              expand: true,                  
              cwd: 'imgs/',                   
              src: ['**/*.{png,jpg,gif}'],   
              dest: '.tmp/assets/imgs'                  
            }]
          }
        },
        // minify svgs and preserve classes and IDs
        svgmin: {
          options:{
            full:true,
            plugins:[
              { cleanupIDs: false },
              { removeViewBox: false },
              { removeUselessStrokeAndFill: false},
              { convertPathData: { straightCurves: false }}
            ]
          },
          dist:{
            files:[{
              expand:true,
              cwd:"imgs/",
              src:["**/*.svg"],
              dest: ".tmp/assets/imgs/",
              ext:".min.svg"
            }]
          }
        },
        // check js/ for syntax and other errors
        // don't check js/libs/
        jshint: {
            all: ['Gruntfile.js','js/*.js','!js/libs/**/*.js'],
            options:{
                reporter: require('jshint-stylish'),
            },
        },// minify concatenated js
        uglify: {
            js: {
                files: {
                    '.tmp/assets/js/<%= clientName %>.min.js': ['.tmp/assets/js/<%= clientName %>.min.js']
                }
            },
            // minify and export modernizr to .tmp/assets/js/libs/
            modernizr:{files:{'.tmp/assets/js/libs/modernizr.custom.min.js': ['js/libs/modernizr.custom.js']}}
        },

        // Empties .tmp folders to start fresh "grunt build"
        clean: {
          dist: [
            ".tmp/**/*",
            ".sass-cache"
            ],
          sourcemap:["css/style.css.map"]
        },
        //replace all _paperTheme reference in project with <%= clientName %>
       replace: {
          underscoresRefs: {
            src: '../<%= clientName %>/**/*.{php,css}',       
            overwrite:true,             
            replacements: [{
              from:  ' _paperTheme',                   
              to: ' <%= clientName %>'
            },{
              from: '@package _paperTheme',
              to: '@package <%= clientName %>'
            },{
              from: '_paperTheme_',
              to: '<%= clientName %>_'
            },{
              from: "'_paperTheme'",
              to: "'<%= clientName %>'"
            }]
          },
          assetsRefs: {
            src: ['../<%= clientName %>/**/**.php'],       
            overwrite:true,             
            replacements: [{
              // point /imgs, /js, and /css to proper assets folder
              from:  /(\/assets)?\/(imgs|js|css)|(\/)(imgs|js|css)|(imgs|js|css)(\/)\b/g,                   
              to: function (matchedWord) { 
                
                var matchedAsset = matchedWord.split('/');
                if(matchedAsset[0] === ''){ return "/assets" + matchedWord;} 
                else if(matchedAsset[0] == 'imgs'){ return "assets/" + matchedWord;} 
                else { return matchedWord;}
              }
            },
            {
              // add ".min " ref to enquequed files
              from: /(\.min)?\.(css|js|svg)|\.(css|js|svg)/g,
              to: function (matchedWord) { 

                var match = matchedWord.split(".");

                if(match[1] != 'min'){
                  return ".min" + matchedWord; 
                }else{
                  return matchedWord; 
                }
                
              }
            }]
          },
          fontsRefs:{
            src: '../<%= clientName %>/assets/css/**/*.css',       
            overwrite:true, 
            replacements:[{
              from: /'fonts\/\b/g,
              to: function (matchedWord) { 
                return "dist/assets/css/" + matchedWord; }
            }]
          }
        },

        shell:{
          gitAddCommit:{
            command:[
            'git add .',
            'git status',
            'git commit -a -m"DEPLOYED FROM `git log -1 --pretty=format:"[%C(green)%h%Creset]%C(yellow)%d%Creset"` \n `git log -1 --pretty=format:"%s"`\n " ',
            'git log -1'
            ].join('&&')
          },
        },
        // git push origin master
        gitpush:{
          production:{
            options: {remote:'origin', branch: 'master'}
          }
        },
        notify:{
          watch: {
            options: {
              title: 'Watch Complete',  // optional
              message: 'compile, prefix, minify finished running', //required
            }
          },
        },
        // run tasks concurrently to attempt to speed up execution
        // to measure execution uncomment "require('time-grunt')(grunt);""
        concurrent: {
          compile: ['clean:sourcemap', 'compass:dev', 'jshint', ],
          prefix :['autoprefixer','concat', ],
          minify: ['cssmin', 'uglify', 'imagemin']
        },

       watch: {
            files: ['scss/**/*.scss', 'css/*', 'js/*.js', 'imgs/**/*.{png,jpg,jpeg,gif,svg}'],
            // tasks: ['compass:dev','autoprefixer','jshint','concat', 'cssmin', 'uglify', 'imagemin']
            tasks:['concurrent', 'notify:watch']
        }
    });
    // register "grunt watch" task for use
    grunt.registerTask('default', ['autoprefixer','concat','cssmin:css','jshint','uglify']);

    // setup and register "grunt test-js" task for use
    grunt.registerTask('test-js', ['jshint', 'concat:js', 'uglify:js']);

    // setup and register "grunt build" to generate production theme
    grunt.registerTask('build', ['clean',
                                 'compass:prod',
                                 'autoprefixer',
                                 'concat',
                                 'imagemin',
                                 'svgmin',
                                 'cssmin',
                                 'jshint',
                                 'uglify',
                                 'copy',
                                 'replace']);

    
    // note: 'grunt build' should be ran before this command
    grunt.registerTask('deploy', ['clean',
                                  'build',
                                  'shell:gitAddCommit',
                                  'gitpush:production']);
};


/* =======================================================================
Grunt Tasks list    
========================================================================== */
// grunt watch 
// grunt clean = clear .tmp/ , .sass-cache/, and sourcemaps
// grunt test-js = check all javascript, concat js, and minify js 
// grunt build = build out optimized production theme locally for testing 
// grunt deploy - runs grunt build and then git commits and pushs 
