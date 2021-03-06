module.exports = function(grunt) {
    grunt.initConfig({
        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    "assets/css/main.css": "assets/sass/main.scss"
                }
            }
        },

        watch: {
            options: {
                livereload: false,
            },
            styles: {
                files: ['assets/sass/**/*.scss'], // which files to watch
                tasks: ['sass'],
                options: {
                    nospawn: true
                }
            }
        },

        phplint: {
            base: ["*.php"],
            actions: ["actions/*.php"]
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks("grunt-phplint");
    grunt.registerTask('default', ['phplint', 'sass', 'watch']);
};
