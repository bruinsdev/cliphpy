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
          '--classpath ./app/'
          '--deploypath ./autoloader/'
        ].join(' ')

    phpunit:
      Application:
        dir: './app/'
      options:
        bin: './bower_components/php-unit/phpunit'
        colors: true
        coveragePhp: true
        verbose: true
        coverageHtml: './test/unit/report'
        testdoxHtml: './test/unit/testdox.html'
        bootstrap: './test/unit/bootstrap.php'

    watch:
      files:
        [
          './app/**/*.php'
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
      'shell:autoloader'
      'phpunit'
      'shell:cleanUp'
      'watch'
    ]