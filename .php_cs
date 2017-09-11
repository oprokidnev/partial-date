<?php
$finder = PhpCsFixer\Finder::create()
    ->in('src')
    ->in('tests')
;
global $argv;

\PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer::class;
$config = PhpCsFixer\Config::create();
\PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer::class;
$rules = [
    '@PSR1' => true,
    '@PSR2' => true,
    'lowercase_cast' => true,
    'array_syntax' => [
        'syntax' => 'short'
    ],
    'native_function_casing' => true,
    'new_with_braces' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_leading_import_slash' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'ordered_imports' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_align' => true,
    'phpdoc_scalar' => true,
    'phpdoc_indent' => true,
    'phpdoc_separation' => true,
    'return_type_declaration' => true,
    'phpdoc_types' => true,
    'short_scalar_cast' => true,
    'single_quote' => true,
    'standardize_not_equals' => true,
    'ordered_class_elements' => [
        'use_trait',
        'constant_public',
        'constant_protected',
        'constant_private',
        'property_public',
        'property_protected',
        'property_private',
        'construct',
        'destruct',
        'magic',
        'phpunit',
        'method_public',
        'method_protected',
        'method_private',
    ],
    'no_mixed_echo_print' => [
        'use' => 'echo'
    ],
    'header_comment' => [
        'commentType' => \PhpCsFixer\Fixer\Comment\HeaderCommentFixer::HEADER_COMMENT,
        'header' => sprintf(<<<'HEADER_COMMENT'
Copyright %s Oprokidnev Andrey

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
HEADER_COMMENT
            ,date('Y'))
    ],
];

$riskyRules = [
    'native_function_invocation' => true,
];


if (stristr(implode(' ', $argv), '--allow-risky')) {
    $rules = \array_merge($rules, $riskyRules);
}

$config->setRules($rules);
$config->setFinder($finder);
return $config;
