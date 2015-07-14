'use strict';
module.exports = function ( grunt ) {

    // load all grunt tasks matching the `grunt-*` pattern
    // Ref. https://npmjs.org/package/load-grunt-tasks
    require( 'load-grunt-tasks' )( grunt );

    grunt.initConfig( {
        // watch for changes and trigger sass, jshint, uglify and livereload
        watch: {
            sass: {
                files: [ 'sass/**/*.{scss,sass}' ],
                tasks: [ 'sass', 'autoprefixer' ]
            },
            js: {
                files: [ '<%= uglify.frontend.src %>', '<%= uglify.backend.src %>' ],
                tasks: [ 'uglify' ]
            },
            livereload: {
                // Here we watch the files the sass task will compile to
                // These files are sent to the live reload server after sass compiles to them
                options: { livereload: true },
                files: [ '*.php', '*.css' ]
            }
        },
        // sass
        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    'app/assets/admin/css/admin.css': 'app/assets/admin/css/sass/admin.scss',
                    'app/assets/admin/css/widget.css': 'app/assets/admin/css/sass/widget.scss'
                }
            }
        },
        // autoprefixer
        autoprefixer: {
            options: {
                browsers: [ 'last 2 versions', 'ie 9', 'ios 6', 'android 4' ],
                map: true
            },
            files: {
                expand: true,
                flatten: true,
                src: 'app/assets/admin/css/*.css',
                dest: 'app/assets/admin/css/'
            }
        },
        // cssmin
        cssmin: {
            compress: {
                files: {
                    'app/assets/admin/css/admin.min.css': [ 'app/assets/admin/css/admin.css' ],
                    'app/assets/admin/css/widget.min.css': [ 'app/assets/admin/css/widget.css' ]
                }
            }
        },        
        // Uglify Ref. https://npmjs.org/package/grunt-contrib-uglify
        uglify: {
            options: {
                banner: '/*! \n * rtMedia JavaScript Library \n * @package rtMedia \n */',
            },
            frontend: {
                src: [
					'app/assets/js/vendors/magnific-popup.js',
					'app/assets/admin/js/vendors/tabs.js',
					'app/assets/js/rtMedia.js'
                ],
				dest: 'app/assets/js/rtmedia.min.js'
            },
            backend: {
				src: [
					'app/assets/admin/js/vendors/tabs.js',
					'app/assets/admin/js/scripts.js',
					'app/assets/admin/js/admin.js'
				],
				dest: 'app/assets/admin/js/admin.min.js'
			}
        },
        checktextdomain: {
            options: {
                text_domain: 'rtmedia', //Specify allowed domain(s)
                keywords: [ //List keyword specifications
                    '__:1,2d',
                    '_e:1,2d',
                    '_x:1,2c,3d',
                    'esc_html__:1,2d',
                    'esc_html_e:1,2d',
                    'esc_html_x:1,2c,3d',
                    'esc_attr__:1,2d',
                    'esc_attr_e:1,2d',
                    'esc_attr_x:1,2c,3d',
                    '_ex:1,2c,3d',
                    '_n:1,2,4d',
                    '_nx:1,2,4c,5d',
                    '_n_noop:1,2,3d',
                    '_nx_noop:1,2,3c,4d'
                ]
            },
            target: {
                files: [ {
                        src: [
                            '*.php',
                            '**/*.php',
                            '!node_modules/**',
                            '!tests/**'
                        ], //all php
                        expand: true
                    } ]
            }
        },
        makepot: {
            target: {
                options: {
                    cwd: '.', // Directory of files to internationalize.
                    domainPath: 'languages/', // Where to save the POT file.
                    exclude: [ 'node_modules/*' ], // List of files or directories to ignore.
                    mainFile: 'index.php', // Main project file.
                    potFilename: 'rtmedia.po', // Name of the POT file.
                    potHeaders: { // Headers to add to the generated POT file.
                        poedit: true, // Includes common Poedit headers.
                        'Last-Translator': 'rtCamp <support@rtcamp.com>',
                        'Language-Team': 'rtCampers <support@rtcamp.com>',
                        'report-msgid-bugs-to': 'http://community.rtcamp.com/c/rtmedia/',
                        'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
                    },
                    type: 'wp-plugin', // Type of project (wp-plugin or wp-theme).
                    updateTimestamp: true // Whether the POT-Creation-Date should be updated without other changes.
                }
            }
        },
        addtextdomain: {
            options: {
                //i18nToolsPath: '', // Path to the i18n tools directory.
                textdomain: 'rtmedia', // Project text domain.
                updateDomains: [ 'test' ]  // List of text domains to replace.
            },
            target: {
                files: {
                    src: [
                        '*.php',
                        '**/*.php',
                        '!node_modules/**',
                        '!tests/**'
                    ]
                }
            }
        }

    } );
    // register task
    grunt.registerTask( 'default', [ 'sass', 'autoprefixer', 'cssmin', 'uglify', 'checktextdomain', 'makepot', 'watch' ] );
};
