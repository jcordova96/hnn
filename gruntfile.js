module.exports = function(grunt) {

    grunt.initConfig({
        watch: {
            files: [
                'assets/js/ng/**/*.js',
                'assets/js/ng/**/*.html',
                'assets/js/app/**/*.js',
                'assets/js/vendor/**/*.js',
                '!**/node_modules/**/*.js',
                'css/hnn/**/*.css',
                'js/**/*.js'
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
                    'js/google-code-prettify/prettify.js',
                    'js/respond.js',
                    'js/superfish.js',
                    'js/hoverIntent.js',
                    'js/jquery.easing.1.3.js',
                    'js/jquery.prettyPhoto.js',
                    'js/jquery.hoverdir.js',
                    'js/jquery.flexslider.js',
                    'js/jquery.elastislide.js',
                    'js/jquery.tweet.js',
                    'js/bootstrap.js',
                    'js/main.js'
                ],
                dest: 'assets/js/foot.js'
            },
            style: {
                src: [
                    'css/hnn/bootstrap.css',
                    'css/hnn/bootstrap-responsive.css',
                    'css/hnn/style.css',
                    'css/hnn/responsive.css',
                    'css/hnn/skin-default.css',
                    'css/hnn/prettyPhoto.css'
                ],
                dest: 'assets/css/style.css'
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
