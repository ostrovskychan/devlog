<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;

return RectorConfig::configure()
    ->withCache(__DIR__ . '/../cache')
    ->withPaths([
        __DIR__ . '/../../../public',
    ])
    ->withPhpSets(php86: true)
    ->withPreparedSets(
        privatization: true,
        naming: false,
        instanceOf: true,
        earlyReturn: true,
        carbon: false,
        rectorPreset: true,
    )
    ->withSkip([
		// to be done
    ]);
