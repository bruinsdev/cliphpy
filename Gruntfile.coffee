module.exports = (grunt) ->

  grunt.initConfig
    shell:
      install:
        command: [
          'cd ./bower_components/php-unit'
          'curl -sS https://getcomposer.org/installer | /usr/bin/php'
          '/usr/bin/php composer.phar install'
          ].join(';')
        options:
          stdout: true

      removeAutoloader:
        command: 'rm -fr ./autoloader'

      cleanUp:
        command: 'rm -fr true'

      cleanUpTestTmp:
        command: 'rm -fr test/tmp'

      autoloader:
        command: [
          'php ./bower_components/php-autoloader/scripts/autoloader-build.php'
          '--classpath Interfaces/'
          '--classpath Prototypes/'
          '--classpath Lib/'
          '--deploypath autoloader/'
        ].join(' ')

      removeReports:
        command: 'rm -rf test/unit/report'

    phpunit:
      Library:
        dir: 'Lib/'
        options:
          coverageHtml: 'test/unit/report/Lib'
      Prototype:
        dir: 'Prototypes/'
        options:
          coverageHtml: 'test/unit/report/Prototypes'
      options:
        bin: 'bower_components/php-unit/phpunit'
        colors: true
        verbose: true
        bootstrap: 'test/unit/bootstrap.php'


    watch:
      files:
        [
          'Lib/**/*.php'
          'Prototypes/**/*.php'
        ]
      tasks:
        [
          'shell:cleanUpTestTmp'
          'shell:autoloader'
          'phpunit'
          'shell:cleanUp'
        ]

  grunt.loadNpmTasks 'grunt-shell'
  grunt.loadNpmTasks 'grunt-phpunit'
  grunt.loadNpmTasks 'grunt-contrib-watch'

  grunt.registerTask 'install',
    tasks = [
      'shell:install'
    ]

  grunt.registerTask 'test',
    [
      'shell:autoloader'
      'phpunit'
      'shell:cleanUp'
    ]

  grunt.registerTask 'autoloader',
    tasks = [
      'shell:removeAutoloader'
      'shell:autoloader'
    ]

  grunt.registerTask 'default',
    tasks = [
      'autoloader'
      'shell:cleanUpTestTmp'
      'shell:removeReports'
      'phpunit'
      'shell:cleanUp'
      'watch'
    ]