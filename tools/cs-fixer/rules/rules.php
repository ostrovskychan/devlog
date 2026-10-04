<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = new Finder()
    ->in(__DIR__ . "/../../../")
    ->exclude(['runtime', "tools", 'build', 'deploy', 'vendor']);

return new Config()
    ->setCacheFile(__DIR__ . '/../cache/.php-cs-fixer.cache')
    ->setRiskyAllowed(true)
    ->setRules([
        // strictness:
        'void_return' => true,
        'strict_param' => true,
        'strict_comparison' => true,
        'declare_strict_types' => true,
        'type_declaration_spaces' => true,

        // imports:
        'no_unused_imports' => true,
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'fully_qualified_strict_types' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'single_line_after_imports' => true,

        // code style:
        'yoda_style' => false,
        'single_quote' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_superfluous_elseif' => true,
        'combine_nested_dirname' => true,
        'ternary_to_null_coalescing' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],

        // class, methods, properties:
		'modifier_keywords' => [
			'elements' => ['property', 'method', 'const'],
		],
        'protected_to_private' => true,
        'no_unneeded_final_method' => true,
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'one',
                'method' => 'one',
                'property' => 'one',
                'trait_import' => 'none',
            ],
        ],
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'method_public',
                'method_protected',
                'method_private',
            ],
        ],

        // formatting, spacing:
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_lines_before_namespace' => true,
        'single_blank_line_at_eof' => true,
        'no_whitespace_in_blank_line' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'lowercase_keywords' => true,
        'lowercase_static_reference' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => false,
        ],

        // phpdoc, annotations:
        'no_empty_phpdoc' => true,
        'phpdoc_trim' => true,
        'phpdoc_scalar' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_align' => ['align' => 'left'],
        'no_superfluous_phpdoc_tags' => [
            'remove_inheritdoc' => true,
            'allow_mixed' => true,
        ],
    ])
    ->setFinder($finder);
