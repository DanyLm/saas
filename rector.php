<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnDirectArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnNewRector;
use Rector\ValueObject\PhpVersion;

return static function (RectorConfig $rectorConfig): void {
    // paths to refactor; solid alternative to CLI arguments
    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/bootstrap',
        __DIR__.'/database',
        __DIR__.'/lang',
        __DIR__.'/routes',
    ]);

    // is your PHP version different from the one your refactor to? [default: your PHP version], uses PHP_VERSION_ID format
    $rectorConfig->phpVersion(PhpVersion::PHP_83);
    $rectorConfig->parallel(120, 4, 80);

    $rectorConfig->skip([
        // Dead code
        RemoveUnusedPrivatePropertyRector::class,
        // PHP Version
        SensitiveConstantNameRector::class,
        NullToStrictStringFuncCallArgRector::class,
        // Strict
        DisallowedEmptyRuleFixerRector::class,
        // Type declaration
        AddArrowFunctionReturnTypeRector::class,
        ReturnTypeFromReturnNewRector::class,
        ReturnTypeFromReturnDirectArrayRector::class,
        // Early return
        ChangeOrIfContinueToMultiContinueRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        // Coding style
        EncapsedStringsToSprintfRector::class,
        SymplifyQuoteEscapeRector::class,
        RemoveExtraParametersRector::class,
        AddOverrideAttributeToOverriddenMethodsRector::class,
    ]);

    // Define what rule sets will be applied
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_83,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::TYPE_DECLARATION,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
        PHPUnitSetList::PHPUNIT_100,
    ]);
};
