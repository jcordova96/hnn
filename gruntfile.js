module.exports = function(grunt) {

    grunt.initConfig({
        watch: {
            files: [
                'assets/js/ng/**/*.js',
                'assets/js/ng/**/*.html',
                'assets/js/app/**/*.js',
                'assets/js/vendor/**/*.js',
                '!**/node_modules/**/*.js'
            ],
            tasks: ['dev']
        },
				less: {
					development: {
						options: {
							compress: true,
							optimization: 2
						},
						files: {
							"css/site.css": "protected/less/site.less"
						}
					}
				},
				jshint: {
						all: [
                'assets/js/ng/**/*.js',
                'assets/js/app/**/*.js',
                '!assets/js/ng/svc/local_storage.js'
            ]
        },
        ngtemplates:  {
            app: {
                options: {
                    base: 'assets/js/ng/tpl'
                },
                src: [
                    'assets/js/ng/tpl/**/*.html'
                ],
                dest: 'assets/js/templates.js'
            }
        },
        concat: {
            head: {
                src: [
                    'assets/js/vendor/modernizr/modernizr.js'
                ],
                dest: 'assets/js/head.js'
            },
            foot: {
                src: [
                    'assets/js/vendor/jquery/jquery.js',
                    'assets/js/vendor/slidesjs/source/jquery.slides.js',
                    'assets/js/vendor/lodash/lodash.js',
                    'assets/js/vendor/angular/angular.js',
                    'assets/js/vendor/angular-ui/build/angular-ui.js',
                    'assets/js/vendor/angular-local-storage/localStorageModule.js',
                    'assets/js/vendor/angular-ui-router/build/angular-ui-states.js',
                    'assets/js/vendor/kmonki-ng/build/kmonki-ng.js',
                    'assets/js/app/**/*.js',
                    'assets/js/ng/**/*.js',
                    'assets/js/templates.js'
                ],
                dest: 'assets/js/foot.js'
            }
        },
        uglify: {
            all: {
                files: {
                    'assets/js/foot.js': ['assets/js/foot.js'],
                    'assets/js/head.js': ['assets/js/head.js']
                }
            }
        }
    });

    grunt.registerTask('default', ['less', 'jshint', 'ngtemplates', 'concat', 'uglify']);
    grunt.registerTask('dev', ['less', 'jshint', 'ngtemplates', 'concat']);

		grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-angular-templates');

};
