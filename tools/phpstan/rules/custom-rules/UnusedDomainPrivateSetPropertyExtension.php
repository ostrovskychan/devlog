<?php

declare(strict_types=1);

namespace Devlog\PHPStan;

use PhpParser\Node;
use PHPStan\Analyser\Error;
use PHPStan\Analyser\IgnoreErrorExtension;
use PHPStan\Analyser\Scope;
use PHPStan\Node\CollectedDataNode;
use PHPStan\Reflection\ReflectionProvider;
use TomasVotruba\UnusedPublic\Collectors\PublicPropertyCollector;
use TomasVotruba\UnusedPublic\Rules\UnusedPublicPropertyRule;

/**
 * Silences `public.property.unused` (tomasvotruba/unused-public) for `public private(set)` properties
 * declared under `<src>/**\/Domain/**`.
 *
 * In the Domain, public read access to an object's own state is part of its API, so a `public private(set)`
 * property that nothing happens to read yet is not dead code. A plain `public` property (writable from
 * outside) is still reported, and so is `public private(set)` anywhere outside Domain.
 *
 * Why the error alone is not enough: UnusedPublicPropertyRule emits it from a CollectedDataNode rule with only
 * a message, a file and a line - no metadata - and the collector stores the *class* line for regular
 * properties, so file+line cannot tell two properties of one class apart. The class and property names are
 * therefore read from the collector's own data on the CollectedDataNode (the node PHPStan hands to ignore
 * extensions for such errors), and the matching entry is found by rebuilding the rule's message from its own
 * format constant. Asymmetric visibility itself comes from PHPStan's reflection, never from text.
 */
final class UnusedDomainPrivateSetPropertyExtension implements IgnoreErrorExtension
{
    private const string IDENTIFIER = 'public.property.unused';

    private const string DOMAIN_DIRECTORY = 'Domain';

    private readonly string $sourceDirectory;

    /** @param string|null $sourceDirectory absolute path of the source root; defaults to `<project>/src` */
    public function __construct(
        private readonly ReflectionProvider $reflectionProvider,
        ?string $sourceDirectory = null,
    ) {
        $sourceDirectory ??= dirname(__DIR__, 4) . '/src';

        $this->sourceDirectory = rtrim($this->normalizePath(realpath($sourceDirectory) ?: $sourceDirectory), '/');
    }

    public function shouldIgnore(Error $error, Node $node, Scope $scope): bool
    {
        if ($error->getIdentifier() !== self::IDENTIFIER) {
            return false;
        }

        // Errors of this identifier come from a CollectedDataNode rule; the collector data lives on that node.
        if (!$node instanceof CollectedDataNode) {
            return false;
        }

        $file = $error->getFilePath();
        if (!$this->isInDomain($file)) {
            return false;
        }

        $property = $this->findReportedProperty($node, $file, $error->getMessage());
        if ($property === null) {
            return false;
        }

        [$className, $propertyName] = $property;

        if (!$this->reflectionProvider->hasClass($className)) {
            return false;
        }

        $classReflection = $this->reflectionProvider->getClass($className);
        if (!$classReflection->hasNativeProperty($propertyName)) {
            return false;
        }

        $propertyReflection = $classReflection->getNativeProperty($propertyName);

        // `public private(set)`: readable by everyone, writable only by the declaring class.
        return $propertyReflection->isPublic() && $propertyReflection->isPrivateSet();
    }

    /**
     * Finds which property of $file the given `public.property.unused` message is about.
     *
     * @return array{string, string}|null class name and property name
     */
    private function findReportedProperty(CollectedDataNode $node, string $file, string $message): ?array
    {
        foreach ($node->get(PublicPropertyCollector::class)[$file] ?? [] as $declarations) {
            foreach ($declarations as [$className, $propertyName]) {
                if (sprintf(UnusedPublicPropertyRule::ERROR_MESSAGE, $className, $propertyName) === $message) {
                    return [$className, $propertyName];
                }
            }
        }

        return null;
    }

    /** True when the file sits in a directory named `Domain` somewhere below the source root. */
    private function isInDomain(string $file): bool
    {
        $file = $this->normalizePath($file);

        if (!str_starts_with($file, $this->sourceDirectory . '/')) {
            return false;
        }

        $directories = explode('/', dirname(substr($file, strlen($this->sourceDirectory) + 1)));

        return in_array(self::DOMAIN_DIRECTORY, $directories, true);
    }

    private function normalizePath(string $path): string
    {
        return str_replace('\\', '/', $path);
    }
}
