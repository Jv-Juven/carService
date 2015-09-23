module.exports = (grunt)->

    stringify = require 'stringify'
    coffeeify = require 'coffeeify'

    grunt.initConfig
        concurrent:
            dev:
                tasks: ["nodemon", "watch"]
                options:
                    logConcurrentOutput: true
        copy:
            dev:
                files: [
                    # {expand: true, flatten: true, src: ["lib/js/*"], dest: 'dist/lib/js/'}
                    # {expand: true, flatten: true, src: ["lib/css/*"], dest: 'dist/lib/css/'}
                ]

        clean:
            dist: ['dist']

        browserify:
            components:
                options:
                  preBundleCB: (b)->
                    b.transform(coffeeify)
                    b.transform(stringify({extensions: ['.hbs', '.html', '.tpl', '.txt']}))
                expand: true
                flatten: true
                files: {
                    # 'dist/js/components.js': ['src/components/**/*.coffee']
                    # 'dist/js/common.js': ['src/common/**/*.coffee']
                }

            pages:
                options:
                  preBundleCB: (b)->
                    b.transform(coffeeify)
                    b.transform(stringify({extensions: ['.hbs', '.html', '.tpl', '.txt']}))
                expand: true
                flatten: true
                src: ['src/pages/**/*.coffee']
                dest: 'dist/js/pages/'
                ext: '.js'

        watch:
            compile:
                options:
                    livereload: 1337
                files: ['src/**/*.less', 'src/**/*.coffee']
                tasks: ['browserify', 'less']

        less:
            common:
                files:
                    'dist/css/common.css': ['src/common/*.less']

            components:
                files:
                    'dist/css/components.css': ['src/components/**/*.less']
                    # 'dist/pc/css/components.css': ['src/pc/components/**/*.less']
            pages:
                files:
                    #serve-center
                    'dist/css/pages/login.css': ['src/pages/login/login.less']
                    'dist/css/pages/serve-center/business/violation.css': ['src/pages/serve-center/business/violation.less']
                    'dist/css/pages/serve-center/serve.css': ['src/pages/serve-center/serve.less']
                    'dist/css/pages/serve-center/business/agency.css': ['src/pages/serve-center/business/agency.less']
                    'dist/css/pages/serve-center/business/pay.css': ['src/pages/serve-center/business/pay.less']

                    # message-center
                    'dist/css/pages/message-center/feedback.css': ['src/pages/message-center/feedback.less']
                    'dist/css/pages/message-center/message-all.css': ['src/pages/message-center/message-all.less']
                    'dist/css/pages/message-center/message-read.css': ['src/pages/message-center/message-read.less']
                    'dist/css/pages/message-center/message-unread.css': ['src/pages/message-center/message-unread.less']

        cssmin:
            mobile:
                files:[
                    {
                        expand: true,
                        cwd: 'dist/css',
                        src: ['*.css', '!*.min.css'],
                        dest: 'dist/css',
                        ext: '.css'
                    },
                    {
                        expand: true,
                        cwd: 'dist/css/pages',
                        src: ['*.css', '!*.min.css'],
                        dest: 'dist/css/pages',
                        ext: '.css'
                    }
                ]
            pc:
                files:[
                    {
                        expand: true,
                        cwd: 'dist/pc/css',
                        src: ['*.css', '!*.min.css'],
                        dest: 'dist/pc/css',
                        ext: '.css'
                    },
                    {
                        expand: true,
                        cwd: 'dist/pc/css/pages',
                        src: ['*.css', '!*.min.css'],
                        dest: 'dist/pc/css/pages',
                        ext: '.css'
                    }
                ]

        uglify:
            mobile:
                files:[
                    {
                        expand: true,
                        cwd: 'dist/js/',
                        src: '**/*.js',
                        dest: 'dist/js/'
                    }
                ]
            pc:
                files:[
                    {
                        expand: true,
                        cwd: 'dist/pc/pages',
                        src: '**/*.js',
                        dest: 'dist/pc/pages'
                    }
                ]

    grunt.loadNpmTasks 'grunt-browserify'
    grunt.loadNpmTasks 'grunt-contrib-less'
    grunt.loadNpmTasks 'grunt-contrib-copy'
    grunt.loadNpmTasks 'grunt-contrib-clean'
    grunt.loadNpmTasks 'grunt-contrib-watch'
    grunt.loadNpmTasks 'grunt-contrib-uglify'
    grunt.loadNpmTasks 'grunt-contrib-cssmin'
    grunt.loadNpmTasks 'grunt-contrib-less'

    grunt.registerTask 'default', ->
        grunt.task.run [
            'clean'
            'copy'
            'browserify'
            'less'
            'watch'
        ]

    grunt.registerTask 'prod', ->
        grunt.task.run [
            'clean'
            'copy'
            'browserify'
            'less'
            'uglify'
            'cssmin'
        ]

