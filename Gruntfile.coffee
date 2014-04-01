module.exports = (grunt) ->

  grunt.initConfig
    shell:
      install:
        command: [
          'cd ./bower_components/php-unit'
          'curl -sS https://getcomposer.org/installer | php'
          'php composer.phar install'
          ].join(';')
        options:
          stdout: true

      removeAutoloader:
        command: 'rm -fr ./autoloader'

      cleanUp:
        command: 'rm -fr true'

      autoloader:
        command: [
          'php ./bower_components/php-autoloader/scripts/autoloader-build.php'
          '--classpath lib/'
          '--classpath prototype/'
          '--deploypath autoloader/'
        ].join(' ')

      removeReports:
        command: 'rm -rf test/unit/report'

    phpunit:
      Library:
        dir: 'lib/'
        options:
          coverageHtml: 'test/unit/report/lib'
      Prototype:
        dir: 'prototype/'
        options:
          coverageHtml: 'test/unit/report/prototype'
      options:
        bin: 'bower_components/php-unit/phpunit'
        colors: true
        verbose: true
        bootstrap: 'test/unit/bootstrap.php'


    watch:
      files:
        [
          'lib/*.php'
          'prototype/*.php'
        ]
      tasks:
        [
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
      'shell:removeReports'
      'phpunit'
      'shell:cleanUp'
      'watch'
    ]