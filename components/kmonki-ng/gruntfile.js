module.exports = function(grunt) {

    grunt.initConfig({
        watch: {
            files: [
                'modules/**/*.js'
            ],
            tasks: ['jshint', 'concat']
        },
        jshint: {
            package: [
                'modules/**/*.js'
            ]
        },
        concat: {
            package: {
                src: [
                    'modules/**/*.js'
                ],
                dest: 'build/kmonki-ng.js'
            },
            withdeps: {
                src: [
                    'vendor/lodash/lodash.js',
                    'vendor/jquery/jquery.js',
                    'vendor/angular/angular.js',
                    'vendor/angular-local-storage/localStorageModule.js',
                    'modules/**/*.js'
                ],
                dest: 'build/kmonki-ng.withdeps.js'
            }
        },
        uglify: {
            package: {
                files: {
                    'build/kmonki-ng.min.js': ['build/kmonki-ng.js']
                }
            },
            withdeps: {
                files: {
                    'build/kmonki-ng.withdeps.min.js': ['build/kmonki-ng.withdeps.js']
                }
            }
        }
    });

    grunt.registerTask('default', ['jshint', 'concat', 'uglify']);

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');

};
