module.exports = function (grunt)
{

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // minify js
        uglify: {
            options: {
                sourceMap: true
            },

            global: {
                files: {
                    'public/js/main.min.js': [ 'public/js/*.js' ]
                }
            },

            specific: {
                files: [
                    {
                        expand: true,
                        cwd   : 'public/js',
                        src   : [ '**/*.js', '!*.js', '!**/*.min.js' ],
                        dest  : 'public/js',
                        ext   : '.min.js',
                        extDot: 'last'
                    }
                ]
            }
        },

        // minify css
        cssmin: {
            options: {
                sourceMap: true
            },

            // merge all generic styles in one file
            global: {
                files: {
                    'public/css/main.min.css': [ 'public/css/*.css' ]
                }
            },

            // minify each specific style
            specific: {
                files: [
                    {
                        expand: true,
                        cwd   : 'public/css',
                        src   : [ '*/**/*.css', '!**/*.min.css' ],
                        dest  : 'public/css',
                        ext   : '.min.css',
                        extDot: 'last'
                    }
                ]
            }
        },

        // mirror less files to css directory
        less: {
            development: {
                options: {
                    sourceMap: true
                },
                files  : [
                    {
                        expand: true,
                        cwd   : 'public/less',
                        src   : [ '**/*.less', '!src/**' ],
                        dest  : 'public/css',
                        ext   : '.css',
                        extDot: 'last'
                    }
                ]
            }
        },

        watch: {
            less: {
                files: [ 'public/less/**/*.less' ],
                tasks: [ 'less' ]
            },

            styles_global  : {
                files: [ 'public/less/*.less' ],
                tasks: [ 'cssmin:global' ]
            },
            styles_specific: {
                files: [ 'public/less/*/**/*.less' ],
                tasks: [ 'cssmin:specific' ]
            },

            scripts_global  : {
                files: [ 'public/js/*.js', '!**/*.min.js' ],
                tasks: [ 'uglify:global' ]
            },
            scripts_specific: {
                files: [ 'public/js/*/**/*.js', '!**/*.min.js' ],
                tasks: [ 'uglify:specific' ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('build', ['less', 'cssmin', 'uglify', 'watch']);
};