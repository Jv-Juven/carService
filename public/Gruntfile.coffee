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
                    'dist/js/components.js': ['src/components/**/*.coffee']
                    # 'dist/js/common.js': ['src/common/**/*.coffee']
                }
            account_center:
                options:
                  preBundleCB: (b)->
                    b.transform(coffeeify)
                    b.transform(stringify({extensions: ['.hbs', '.html', '.tpl', '.txt']}))
                expand: true
                flatten: true
                src: ['src/pages/account-center/**/*.coffee']
                dest: 'dist/js/pages/account-center'
                ext: '.js'
            finance_center:
                options:
                  preBundleCB: (b)->
                    b.transform(coffeeify)
                    b.transform(stringify({extensions: ['.hbs', '.html', '.tpl', '.txt']}))
                expand: true
                flatten: true
                files: {
                    'dist/js/pages/finance-center/cost-manage/cost-detail.js': ['src/pages/finance-center/cost-manage/cost-detail.coffee']
                }
            message_center:
                options:
                  preBundleCB: (b)->
                    b.transform(coffeeify)
                    b.transform(stringify({extensions: ['.hbs', '.html', '.tpl', '.txt']}))
                expand: true
                flatten: true
                files: {
                    'dist/js/pages/message-center/feedback/index.js': ['src/pages/message-center/feedback/index.coffee']
                }
            register_b:
                options:
                  preBundleCB: (b)->
                    b.transform(coffeeify)
                    b.transform(stringify({extensions: ['.hbs', '.html', '.tpl', '.txt']}))
                expand: true
                flatten: true
                src: ['src/pages/register-b/**/*.coffee']
                dest: 'dist/js/pages/register-b'
                ext: '.js'
            serve_center:
                options:
                  preBundleCB: (b)->
                    b.transform(coffeeify)
                    b.transform(stringify({extensions: ['.hbs', '.html', '.tpl', '.txt']}))
                expand: true
                flatten: true
                src: ['src/pages/serve-center/**/*.coffee']
                dest: 'dist/js/pages/serve-center'
                ext: '.js'
            login:
                options:
                  preBundleCB: (b)->
                    b.transform(coffeeify)
                    b.transform(stringify({extensions: ['.hbs', '.html', '.tpl', '.txt']}))
                expand: true
                flatten: true
                src: ['src/pages/login/**/*.coffee']
                dest: 'dist/js/pages/login'
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
                    'dist/css/common.css': [
                        'src/common/common.less'
                        'src/common/master.less'
                        'src/common/public.less'
                    ]
                    'dist/css/common/pay/success.css': ['src/common/pay/success.less']
                    'dist/css/common/pay/fail.css': ['src/common/pay/fail.less']
                    'dist/css/common/pay/wechat.css': ['src/common/pay/wechat.less']
                    'dist/css/common/mask/mask.css': ['src/common/mask/mask.less']

            components:
                files:
                    'dist/css/components.css': [
                        'src/components/left-nav.less',
                        'src/components/log-reg-mask.less'
                        'src/components/vio-process.less'
                        'src/components/warn-mask.less'
                        'src/components/header.less'
                    ]
                    
            pages:
                files:
                    #serve-center
                    'dist/css/pages/login.css': ['src/pages/login/login.less']
                    'dist/css/pages/serve-center/business/violation.css': ['src/pages/serve-center/business/violation.less']
                    'dist/css/pages/serve-center/serve.css': ['src/pages/serve-center/serve.less']
                    'dist/css/pages/serve-center/business/agency.css': ['src/pages/serve-center/business/agency.less']
                    'dist/css/pages/serve-center/business/pay.css': ['src/pages/serve-center/business/pay.less']
                    'dist/css/pages/serve-center/business/success.css': ['src/pages/serve-center/business/success.less']
                    'dist/css/pages/serve-center/indent/indent-agency.css': ['src/pages/serve-center/indent/indent-agency.less']
                    'dist/css/pages/serve-center/data/drive.css': ['src/pages/serve-center/data/drive.less']
                    'dist/css/pages/serve-center/data/cars.css': ['src/pages/serve-center/data/cars.less']

                    #register-b
                    'dist/css/pages/register-b/baseinfo.css': ['src/pages/register-b/baseinfo.less']
                    'dist/css/pages/register-b/email-active.css': ['src/pages/register-b/email-active.less']
                    'dist/css/pages/register-b/reg-info.css': ['src/pages/register-b/reg-info.less']
                    'dist/css/pages/register-b/success/success.css': ['src/pages/register-b/success.less']

                    #accountc-center
                    'dist/css/pages/account-center/developer-info.css': ['src/pages/account-center/developer-info.less']
                    'dist/css/pages/account-center/account-info.css': ['src/pages/account-center/account-info.less']

                    # message center
                    'dist/css/pages/message-center/feedback/index.css': ['src/pages/message-center/feedback/index.less']
                    'dist/css/pages/message-center/feedback/success.css': ['src/pages/message-center/feedback/success.less']
                    'dist/css/pages/message-center/message/home.css': ['src/pages/message-center/message/home.less']
                    'dist/css/pages/message-center/message/base.css': ['src/pages/message-center/message/base.less']
                    'dist/css/pages/message-center/message/detail.css': ['src/pages/message-center/message/detail.less']

                    # finance center
                    'dist/css/pages/finance-center/cost-manage/overview.css':['src/pages/finance-center/cost-manage/overview.less']
                    'dist/css/pages/finance-center/cost-manage/cost-detail.css':['src/pages/finance-center/cost-manage/cost-detail.less']
                    'dist/css/pages/finance-center/cost-manage/refund-record.css':['src/pages/finance-center/cost-manage/refund-record.less']
                    'dist/css/pages/finance-center/recharge/index.css': ['src/pages/finance-center/recharge/index.less']

        cssmin:
            common:
                files:[
                    {
                        expand: true,
                        cwd: 'dist/css/common',
                        src: ['**/*.css', '!*.min.css'],
                        dest: 'dist/css/common',
                        ext: '.css'
                    }
                ]
            pages:
                files:[
                    {
                        expand: true,
                        cwd: 'dist/css/pages',
                        src: ['**/*.css', '!*.min.css'],
                        dest: 'dist/css/pages',
                        ext: '.css'
                    }
                ]

        uglify:
            common:
                files:[
                    {
                        expand: true,
                        cwd: 'dist/js/common',
                        src: '**/*.js',
                        dest: 'dist/js/common'
                    }
                ]
            pages:
                files:[
                    {
                        expand: true,
                        cwd: 'dist/js/pages',
                        src: '**/*.js',
                        dest: 'dist/js/pages'
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

