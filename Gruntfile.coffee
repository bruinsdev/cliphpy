module.exports = (grunt) ->

  grunt.initConfig
    shell:
      cleanUpTestTmp:
        command: 'rm -rf test/tmp'

      test:
        command: 'make test'
        options:
          stdout: true

    watch:
      files:
        [
          'Cliphpy/**/*.php'
          'test/**/*.php'
        ]
      tasks:
        [
          'shell'
        ]

  grunt.loadNpmTasks 'grunt-shell'
  grunt.loadNpmTasks 'grunt-contrib-watch'

  grunt.registerTask 'default',
    tasks = [
      'shell'
      'watch'
    ]
