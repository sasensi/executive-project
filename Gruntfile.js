module.exports = function (grunt)
{

    // Project configuration.
    grunt.initConfig({
        pkg   : grunt.file.readJSON('package.json'),

        uglify: {
            main: {
                files: {
                    'public/js/main.min.js': ['public/js/main.js', 'public/js/form.js']
                }
            }
        },

        cssmin: {
            main: {
                files: {
                    'public/css/style.min.css': ['public/css/style.css']
                }
            }
        },

        less: {
            development: {
                options: {
                    paths: ['public/less/src'],
                    syncImport: true
                },
                files: {
                    'public/css/style.css': 'public/less/style.less'
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.loadNpmTasks('grunt-contrib-less');
};