<?php

$finder = PhpCsFixer\Finder::create()
    ->in('Cliphpy')
    ->in('test')
;

return PhpCsFixer\Config::create()
    ->setRules(
        [
            '@Symfony' => true,
            'array_syntax' => ['syntax' => 'short'],
            'not_operator_with_successor_space' => true,
            'concat_space' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,
            'ordered_imports' => true,
        ]
    )
    ->setUsingCache(true)
    ->setFinder($finder)
;